#!/usr/bin/env node

import mysql from 'mysql2/promise';
import { chromium } from 'playwright';

async function scrapeRatsitPostorter(url) {
    if (!url) {
        console.error('Error: URL is required');
        console.log('Usage: node ratsit_scrape_postorter.mjs "https://www.ratsit.se/personer/Ale-kommun"');
        console.log('This script will scrape all postal areas (postorter) from the given URL and save them to the database.');
        process.exit(1);
    }

    console.log(`Starting Ratsit postal area scraping for: ${url}`);

    let browser = null;
    let connection = null;

    try {
        // Launch browser with realistic settings
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

        // Set additional headers to look more like a real browser
        await page.setExtraHTTPHeaders({
            'Accept-Language': 'sv-SE,sv;q=0.9,en;q=0.8,en-US;q=0.7',
            Accept: 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        });

        // Go to the specific URL
        await page.goto(url, {
            waitUntil: 'networkidle',
            timeout: 30000,
        });

        // Wait for cookie dialog to potentially appear and handle it
        try {
            await page.waitForSelector('#CybotCookiebotDialog', {
                timeout: 5000,
            });
            console.log('Cookie dialog found, trying to accept...');

            // Try to find and click accept button
            const acceptButton = await page.$(
                '#CybotCookiebotDialog button[type="submit"], #CybotCookiebotDialog button, .accept-cookies',
            );
            if (acceptButton) {
                await acceptButton.click();
                console.log('Clicked accept cookies button');
                await page.waitForTimeout(2000);
            }
        } catch (e) {
            console.log('No cookie dialog found or already handled');
        }

        // Wait for content to load
        await page.waitForTimeout(5000);

        // Wait for any dynamic content to load
        await page.waitForTimeout(3000);

        // Check if content has loaded
        await page.waitForFunction(
            () => {
                return document.body && document.body.innerHTML.length > 1000;
            },
            { timeout: 10000 },
        );

        console.log('Page content loaded, extracting postal areas...');

        // Extract postal area information from all letters
        const postorter = await page.evaluate(() => {
            const result = [];

            // Find all list items within tree-structure elements
            // The structure is: <div class="tree-structure__col1"><ul class="tree-structure__ul post-town-list"><li>...</li></ul></div>
            const listItems = document.querySelectorAll('.post-town-list li');

            console.log(`Found ${listItems.length} postal area list items`);

            for (const li of listItems) {
                try {
                    // Find the link within this list item
                    const link = li.querySelector('a');
                    if (!link) continue;

                    const linkText = link.textContent.trim();
                    const href = link.href;

                    // Find the count span (sibling to the link)
                    const countSpan = li.querySelector('.tree-structure__count');
                    const countText = countSpan ? countSpan.textContent.replace(/[^\d]/g, '') : '0';
                    const count = parseInt(countText) || 0;

                    // Parse the link text to extract post_ort and post_nummer
                    // Format: "Sundbyberg - 172 37" or "Sundbyberg - 17237"
                    const match = linkText.match(/^(.+?)\s*-\s*(\d{3}\s?\d{2})$/);

                    if (match) {
                        const postOrt = match[1].trim();
                        const postNummer = match[2].replace(/\s/g, ''); // Remove any spaces from postal code

                        result.push({
                            post_ort: postOrt,
                            post_nummer: postNummer,
                            personer_count: count,
                            personer_link: href,
                        });
                    } else {
                        console.log(`Could not parse: "${linkText}"`);
                    }
                } catch (error) {
                    console.error('Error processing list item:', error);
                }
            }

            return result;
        });

        console.log(`Extracted ${postorter.length} postal areas`);

        if (postorter.length === 0) {
            console.log('No postal areas found. The page structure may have changed.');
            console.log('Please verify the URL and page content.');
        } else {
            // Show first few results
            console.log('\nSample results:');
            postorter.slice(0, 5).forEach((p) => {
                console.log(`  ${p.post_ort} - ${p.post_nummer}: ${p.personer_count} personer`);
            });
        }

        // Database connection
        connection = await mysql.createConnection({
            host: '127.0.0.1',
            port: '3306',
            user: 'root',
            password: 'bkkbkk',
            database: 'filament',
            charset: 'utf8mb4',
        });

        console.log('\nSaving to database...');

        // Save to database
        let savedCount = 0;
        let updatedCount = 0;
        let errorCount = 0;

        for (const postort of postorter) {
            try {
                // Check if this post_ort + post_nummer combination already exists
                const [rows] = await connection.execute(
                    'SELECT id, personer_count FROM ratsit_postorter WHERE post_ort = ? AND post_nummer = ?',
                    [postort.post_ort, postort.post_nummer],
                );

                if (rows.length > 0) {
                    // Update existing record
                    await connection.execute(
                        'UPDATE ratsit_postorter SET personer_count = ?, personer_link = ?, updated_at = NOW() WHERE id = ?',
                        [
                            postort.personer_count,
                            postort.personer_link,
                            rows[0].id,
                        ],
                    );
                    updatedCount++;
                    console.log(`  Updated: ${postort.post_ort} - ${postort.post_nummer} (${postort.personer_count} personer)`);
                } else {
                    // Insert new record
                    await connection.execute(
                        'INSERT INTO ratsit_postorter (post_ort, post_nummer, personer_count, personer_link, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())',
                        [
                            postort.post_ort,
                            postort.post_nummer,
                            postort.personer_count,
                            postort.personer_link,
                        ],
                    );
                    savedCount++;
                    console.log(`  Saved: ${postort.post_ort} - ${postort.post_nummer} (${postort.personer_count} personer)`);
                }
            } catch (error) {
                console.error(`  Error processing ${postort.post_ort} - ${postort.post_nummer}:`, error.message);
                errorCount++;
            }
        }

        console.log('\n=== Summary ===');
        console.log(`Total extracted: ${postorter.length}`);
        console.log(`New records saved: ${savedCount}`);
        console.log(`Existing records updated: ${updatedCount}`);
        console.log(`Errors: ${errorCount}`);
        console.log('\nScraping completed successfully');

    } catch (error) {
        console.error('Scraping error:', error);
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

// Get URL from command line arguments
const url = process.argv[2];

// Run the scraper
scrapeRatsitPostorter(url);
