#!/usr/bin/env node

import fs from 'fs';
import mysql from 'mysql2/promise';
import { chromium } from 'playwright';

async function getRatsitCounts(searchQuery) {
    if (!searchQuery) {
        console.error('Error: Search query is required');
        console.log('Usage: node ratsit_check_counts.mjs "[search_query]"');
        process.exit(1);
    }

    // Remove spaces from postal code for Ratsit search
    const cleanQuery = searchQuery.replace(/\s+/g, '');

    const url = `https://www.ratsit.se/sok/person?vem=${encodeURIComponent(cleanQuery)}`;
    console.log(`Searching: ${url}`);

    let browser = null;

    try {
        // Launch browser with realistic settings
        browser = await chromium.launch({
            headless: true,
            executablePath: '/usr/bin/google-chrome', // Try system Chrome
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

        console.log('Loading page...');

        // Navigate to page and wait for it to load
        await page.goto(url, {
            waitUntil: 'networkidle',
            timeout: 30000,
        });

        // Wait a bit for any dynamic content to load
        await page.waitForTimeout(2000);

        // Try to wait for search segment to appear
        try {
            await page.waitForSelector('.search-segment', { timeout: 10000 });
        } catch (e) {
            console.log('Search segment not found, proceeding anyway...');
        }

        // Get page content
        const content = await page.content();

        // Try multiple patterns to find Personer and Företag values
        let personerMatch = null;
        let foretagMatch = null;

        console.log('Starting pattern matching...');

        // Pattern 1: Look for specific search-segment div
        const searchSegmentMatch = content.match(
            /<div class="search-segment"[^>]*>([^<]+)<\/div>/,
        );
        if (searchSegmentMatch) {
            const segmentText = searchSegmentMatch[1];
            console.log('Pattern 1 - Found search segment:', segmentText);
            personerMatch = segmentText.match(/Personer:\s*([\d\s]+)st/);
            foretagMatch = segmentText.match(/Företag:\s*([\d\s]+)st/);
            console.log('Pattern 1 results - Personer:', personerMatch, 'Företag:', foretagMatch);
        }

        // Pattern 2: Look for any button with Personer/Företag text
        if (!personerMatch || !foretagMatch) {
            console.log('Trying Pattern 2...');
            personerMatch = content.match(/Personer:\s*([\d\s]+)st/);
            foretagMatch = content.match(/Företag:\s*([\d\s]+)st/);
            console.log('Pattern 2 results - Personer:', personerMatch, 'Företag:', foretagMatch);
        }

        // Pattern 3: Try to extract from button elements specifically
        if (!personerMatch || !foretagMatch) {
            console.log('Trying Pattern 3...');
            const buttonTexts = await page.$$eval('button', (buttons) =>
                buttons.map((btn) => btn.textContent || '').join(' '),
            );
            console.log('Button texts found:', buttonTexts);

            personerMatch = buttonTexts.match(/Personer:\s*([\d\s]+)st/);
            foretagMatch = buttonTexts.match(/Företag:\s*([\d\s]+)st/);
            console.log('Pattern 3 results - Personer:', personerMatch, 'Företag:', foretagMatch);
        }

        // Pattern 4: Look for data attributes or other patterns
        if (!personerMatch || !foretagMatch) {
            console.log('Trying Pattern 4...');
            personerMatch = content.match(/"personer":\s*(\d+)/);
            foretagMatch = content.match(/"foretag":\s*(\d+)/);
            console.log('Pattern 4 results - Personer:', personerMatch, 'Företag:', foretagMatch);
        }

        // Pattern 5: Try to get from window object
        if (!personerMatch || !foretagMatch) {
            console.log('Trying Pattern 5...');
            try {
                const windowData = await page.evaluate(() => {
                    // Try to get data from various window objects
                    const data = {};

                    if (window.__INITIAL_STATE__) {
                        data.initialState = window.__INITIAL_STATE__;
                    }

                    if (window.__NUXT__) {
                        data.nuxt = window.__NUXT__;
                    }

                    // Look for any global search data
                    Object.keys(window).forEach((key) => {
                        if (
                            key.toLowerCase().includes('search') ||
                            key.toLowerCase().includes('result')
                        ) {
                            data[key] = window[key];
                        }
                    });

                    return data;
                });

                console.log('Window data keys:', Object.keys(windowData));

                // Search through window data
                const dataString = JSON.stringify(windowData);
                personerMatch = dataString.match(/personer["\s:]+(\d+)/i);
                foretagMatch = dataString.match(/foretag["\s:]+(\d+)/i);
                console.log('Pattern 5 results - Personer:', personerMatch, 'Företag:', foretagMatch);
            } catch (e) {
                console.log('Pattern 5 error:', e.message);
            }
        }

        if (personerMatch && foretagMatch) {
            const personer = parseInt(personerMatch[1].replace(/\s/g, ''), 10);
            const foretag = parseInt(foretagMatch[1].replace(/\s/g, ''), 10);

            console.log(`Found data - personer: ${personer}, foretag: ${foretag}`);

            // Save debug info even when we find data
            fs.writeFileSync('debug_output.html', content);
            console.log('Debug HTML saved for inspection');

            // Update database
            await updateDatabase(searchQuery, personer, foretag, 'ratsit');
        } else {
            console.error('Could not find Personer and Företag values');
            console.log('Matches found - Personer:', personerMatch, 'Företag:', foretagMatch);

            // Save screenshot and HTML for debugging
            await page.screenshot({
                path: 'debug_screenshot.png',
                fullPage: true,
            });
            fs.writeFileSync('debug_output.html', content);
            console.log('Screenshot saved to debug_screenshot.png');
            console.log(
                'HTML content saved to debug_output.html for inspection',
            );
        }
    } catch (error) {
        console.error('Error:', error);
    } finally {
        if (browser) {
            await browser.close();
        }
    }
}

async function updateDatabase(postNummer, personer, foretag, source) {
    let connection = null;

    try {
        // Database connection
        connection = await mysql.createConnection({
            host: '127.0.0.1',
            port: '3306',
            user: 'root',
            password: 'bkkbkk',
            database: 'filament',
            charset: 'utf8mb4',
        });

        // Format postnummer (add space if needed)
        const formattedPostnummer =
            postNummer.length === 5
                ? postNummer.slice(0, 3) + ' ' + postNummer.slice(3)
                : postNummer;

        // Update the database
        const updateFields =
            source === 'hitta'
                ? 'hitta_personer_total = ?, hitta_foretag_total = ?'
                : 'ratsit_personer_total = ?, ratsit_foretag_total = ?';

        // Build additional updates based on counts
        let additionalUpdates = [];
        let additionalValues = [];

        if (source === 'ratsit') {

            if (personer > 0) {
                additionalUpdates.push('merinfo_personer_queue = ?');
                additionalValues.push(true);
                additionalUpdates.push('status = ?');
                additionalValues.push('Counts');
            }
            if (foretag > 0) {
                additionalUpdates.push('merinfo_foretag_queue = ?');
                additionalValues.push(true);
            }
            if (personer < 1)
            {
            additionalUpdates.push('merinfo_personer_queue = ?');
            additionalValues.push(false);
            additionalUpdates.push('status = ?');
            additionalValues.push('Empty ⛔');
            additionalUpdates.push('is_active = ?');
            additionalValues.push(false);
            }
            if (foretag < 1)
            {
               additionalUpdates.push('merinfo_foretag_queue = ?');
                additionalValues.push(false);
            }

        }

        const additionalUpdateString = additionalUpdates.length > 0 ? ', ' + additionalUpdates.join(', ') : '';

        const [result] = await connection.execute(
            `UPDATE post_nums SET ${updateFields}${additionalUpdateString}, updated_at = NOW() WHERE post_nummer = ?`,
            [...[personer, foretag], ...additionalValues, formattedPostNummer],
        );

        if (result.affectedRows > 0) {
            console.log(
                `Database updated: ${formattedPostNummer} -> ${source} personer: ${personer}, företag: ${foretag}`,
            );
        } else {
            console.log(
                `No record found for postnummer: ${formattedPostNummer}`,
            );
        }
    } catch (error) {
        console.error('Database error:', error.message);
    } finally {
        if (connection) {
            await connection.end();
        }
    }
}

// Get search query from command line arguments
const searchQuery = process.argv[2];

// Run the function
getRatsitCounts(searchQuery).catch(console.error);
