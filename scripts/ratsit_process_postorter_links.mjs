#!/usr/bin/env node

/**
 * Process ratsit_postorter table and visit personer_link and foretag_link
 * to extract and save address (adresser) data to ratsit_adresser table
 */

import mysql from 'mysql2/promise';
import { chromium } from 'playwright';

// Database configuration
const dbConfig = {
    host: '127.0.0.1',
    port: '3306',
    user: 'root',
    password: 'bkkbkk',
    database: 'fireflow',
    charset: 'utf8mb4',
};

async function scrapeAddressesFromUrl(page, url, type = 'personer') {
    console.log(`  Visiting ${type} URL: ${url}`);
    
    try {
        await page.goto(url, {
            waitUntil: 'networkidle',
            timeout: 30000,
        });

        // Wait for content
        await page.waitForTimeout(3000);

        // Extract addresses
        const addresses = await page.evaluate(() => {
            const result = [];
            
            // Find all address list items in tree structure
            const listItems = document.querySelectorAll('.post-town-list li, .tree-structure__ul li');
            
            for (const li of listItems) {
                try {
                    const link = li.querySelector('a');
                    if (!link) continue;

                    const linkText = link.textContent.trim();
                    const href = link.href;

                    // Find count span
                    const countSpan = li.querySelector('.tree-structure__count');
                    const countText = countSpan ? countSpan.textContent.replace(/[^\d]/g, '') : '0';
                    const count = parseInt(countText) || 0;

                    // Parse different formats:
                    // Format 1: "Gatunamn - 123 45" (with postal code)
                    // Format 2: "Gatunamn" (just street name)
                    
                    let gatuadressNamn = linkText;
                    
                    // Try to remove postal code if present
                    const match = linkText.match(/^(.+?)\s*-\s*\d{3}\s?\d{2}$/);
                    if (match) {
                        gatuadressNamn = match[1].trim();
                    }

                    if (gatuadressNamn && count > 0) {
                        result.push({
                            gatuadress_namn: gatuadressNamn,
                            count: count,
                            link: href,
                        });
                    }
                } catch (error) {
                    console.error('Error processing list item:', error);
                }
            }

            return result;
        });

        console.log(`    Found ${addresses.length} addresses`);
        return addresses;
        
    } catch (error) {
        console.error(`    Error scraping ${url}:`, error.message);
        return [];
    }
}

async function saveAddresses(connection, postOrt, postNummer, personerKommun, addresses, type = 'personer') {
    const columnPrefix = type === 'personer' ? 'personer' : 'foretag';
    let savedCount = 0;
    
    for (const addr of addresses) {
        try {
            const updateData = {
                [`${columnPrefix}_count`]: addr.count,
                [`${columnPrefix}_link`]: addr.link,
                updated_at: new Date(),
            };
            
            // Check if record exists
            const [rows] = await connection.execute(
                'SELECT id FROM ratsit_adresser WHERE post_ort = ? AND post_nummer = ? AND gatuadress_namn = ?',
                [postOrt, postNummer, addr.gatuadress_namn]
            );
            
            if (rows.length > 0) {
                // Update existing
                const setClauses = Object.keys(updateData).map(k => `${k} = ?`).join(', ');
                const values = [...Object.values(updateData), rows[0].id];
                
                await connection.execute(
                    `UPDATE ratsit_adresser SET ${setClauses} WHERE id = ?`,
                    values
                );
            } else {
                // Insert new
                const insertData = {
                    post_ort: postOrt,
                    post_nummer: postNummer,
                    gatuadress_namn: addr.gatuadress_namn,
                    ...updateData,
                    created_at: new Date(),
                };
                
                const columns = Object.keys(insertData).join(', ');
                const placeholders = Object.keys(insertData).map(() => '?').join(', ');
                
                await connection.execute(
                    `INSERT INTO ratsit_adresser (${columns}) VALUES (${placeholders})`,
                    Object.values(insertData)
                );
            }
            
            savedCount++;
        } catch (error) {
            console.error(`    Error saving address ${addr.gatuadress_namn}:`, error.message);
        }
    }
    
    return savedCount;
}

async function processPostorter() {
    let browser = null;
    let connection = null;
    
    try {
        // Connect to database
        connection = await mysql.createConnection(dbConfig);
        console.log('Connected to database');
        
        // Get total count
        const [countResult] = await connection.execute(
            'SELECT COUNT(*) as total FROM ratsit_postorter WHERE personer_link IS NOT NULL OR foretag_link IS NOT NULL'
        );
        const totalRecords = countResult[0].total;
        console.log(`Total postorter to process: ${totalRecords}\n`);
        
        // Launch browser
        browser = await chromium.launch({
            headless: true,
            executablePath: '/usr/bin/google-chrome',
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-accelerated-2d-canvas',
                '--no-first-run',
                '--no-zygote',
                '--disable-gpu',
            ],
        });

        const context = await browser.newContext({
            userAgent:
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            viewport: { width: 1920, height: 1080 },
            locale: 'sv-SE',
        });

        const page = await context.newPage();
        
        // Handle cookie dialog once
        try {
            await page.goto('https://www.ratsit.se/personer', {
                waitUntil: 'networkidle',
                timeout: 30000,
            });
            
            await page.waitForSelector('#CybotCookiebotDialog', { timeout: 5000 });
            const acceptButton = await page.$('#CybotCookiebotDialog button[type="submit"]');
            if (acceptButton) {
                await acceptButton.click();
                await page.waitForTimeout(2000);
            }
        } catch (e) {
            console.log('Cookie dialog handled or not present\n');
        }

        // Fetch postorter in batches
        let offset = 0;
        const batchSize = 10;
        let processedCount = 0;
        let totalAddressesSaved = 0;
        
        while (true) {
            const [postorter] = await connection.execute(
                `SELECT id, post_ort, post_nummer, personer_link, foretag_link, personer_kommun, foretag_kommun 
                 FROM ratsit_postorter 
                 WHERE personer_link IS NOT NULL OR foretag_link IS NOT NULL
                 ORDER BY id 
                 LIMIT ? OFFSET ?`,
                [batchSize, offset]
            );
            
            if (postorter.length === 0) break;
            
            for (const postort of postorter) {
                processedCount++;
                console.log(`\n[${processedCount}/${totalRecords}] Processing: ${postort.post_ort} ${postort.post_nummer}`);
                
                let addressesSaved = 0;
                
                // Process personer_link
                if (postort.personer_link) {
                    const personerAddresses = await scrapeAddressesFromUrl(page, postort.personer_link, 'personer');
                    if (personerAddresses.length > 0) {
                        const saved = await saveAddresses(
                            connection,
                            postort.post_ort,
                            postort.post_nummer,
                            postort.personer_kommun,
                            personerAddresses,
                            'personer'
                        );
                        addressesSaved += saved;
                        console.log(`    Saved ${saved} personer addresses`);
                    }
                    
                    // Small delay between requests
                    await page.waitForTimeout(1000);
                }
                
                // Process foretag_link
                if (postort.foretag_link) {
                    const foretagAddresses = await scrapeAddressesFromUrl(page, postort.foretag_link, 'foretag');
                    if (foretagAddresses.length > 0) {
                        const saved = await saveAddresses(
                            connection,
                            postort.post_ort,
                            postort.post_nummer,
                            postort.foretag_kommun,
                            foretagAddresses,
                            'foretag'
                        );
                        addressesSaved += saved;
                        console.log(`    Saved ${saved} foretag addresses`);
                    }
                    
                    // Small delay between requests
                    await page.waitForTimeout(1000);
                }
                
                totalAddressesSaved += addressesSaved;
                
                // Update status in ratsit_postorter (if columns exist)
                try {
                    await connection.execute(
                        'UPDATE ratsit_postorter SET personer_link_status = ?, foretag_link_status = ?, updated_at = NOW() WHERE id = ?',
                        [
                            postort.personer_link ? 1 : 0,
                            postort.foretag_link ? 1 : 0,
                            postort.id
                        ]
                    );
                } catch (e) {
                    // Columns might not exist, ignore
                }
            }
            
            offset += batchSize;
            
            // Progress update
            console.log(`\n--- Progress: ${processedCount}/${totalRecords} processed, ${totalAddressesSaved} addresses saved ---`);
        }
        
        console.log('\n=== Summary ===');
        console.log(`Total postorter processed: ${processedCount}`);
        console.log(`Total addresses saved: ${totalAddressesSaved}`);
        console.log('\nProcessing completed successfully!');
        
    } catch (error) {
        console.error('Error:', error);
        process.exit(1);
    } finally {
        if (browser) {
            await browser.close();
        }
        if (connection) {
            await connection.end();
        }
    }
}

// Run the processor
processPostorter();
