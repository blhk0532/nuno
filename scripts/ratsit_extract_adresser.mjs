#!/usr/bin/env node
import { dirname, join } from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const projectRoot = join(__dirname, '..');

async function saveAdressData(
    postOrt,
    postNummer,
    gatuadressNamn,
    personerCount,
    personerLink,
) {
    try {
        const { exec } = await import('child_process');
        const { promisify } = await import('util');
        const execAsync = promisify(exec);

        // Escape single quotes in the data
        const escapedPostOrt = postOrt.replace(/'/g, "\\'");
        const escapedPostNummer = postNummer.replace(/'/g, "\\'");
        const escapedGatuadressNamn = gatuadressNamn.replace(/'/g, "\\'");
        const escapedPersonerLink = personerLink.replace(/'/g, "\\'");

        // Use artisan tinker to save data with upsert for duplicates
        const { stdout, stderr } = await execAsync(
            `cd ${projectRoot} && php artisan tinker --execute="\\App\\Models\\RatsitAdresser::updateOrCreate(['post_ort' => '${escapedPostOrt}', 'post_nummer' => '${escapedPostNummer}', 'gatuadress_namn' => '${escapedGatuadressNamn}'], ['personer_count' => ${personerCount}, 'personer_link' => '${escapedPersonerLink}']); echo 'Saved address: ${escapedGatuadressNamn}, Count: ${personerCount}';"`,
        );

        if (stderr) {
            console.error('Save stderr:', stderr);
        }

        console.log('Save result:', stdout.trim());
        return true;
    } catch (error) {
        console.error('Error saving address data:', error.message);
        return false;
    }
}

async function scrapeRatsitAdresser(url, postOrt, postNummer) {
    console.log(
        `Starting Ratsit address scraping for: ${url} (${postOrt} ${postNummer})`,
    );

    const { chromium } = await import('playwright');
    let browser = null;

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

        // Navigate to URL
        await page.goto(url, { waitUntil: 'networkidle' });

        // Wait for page to load
        await page.waitForTimeout(2000);

        // Handle cookie dialog if present
        try {
            const cookieButton = await page.$(
                'button:has-text("Acceptera alla"), button:has-text("Accept all"), button[data-testid="accept-all-button"]',
            );
            if (cookieButton) {
                await cookieButton.click();
                await page.waitForTimeout(1000);
            }
        } catch (error) {
            console.log('No cookie dialog found or already handled');
        }

        // Look for address links from tree structure
        console.log('Searching for address links...');

        // Find all tree-structure__ul elements (same pattern as ratsit_person_adresser.mjs)
        const addressElements = await page.$$('.tree-structure__ul');

        console.log(`Found ${addressElements.length} address list elements`);

        if (addressElements.length === 0) {
            console.log('No address lists found');
            await browser.close();
            return 0;
        }

        let totalAddresses = 0;

        // Process each ul element
        for (const ulElement of addressElements) {
            // Get all li elements within this ul
            const listItems = await ulElement.$$('li');

            for (const li of listItems) {
                try {
                    // Extract address name and link
                    const linkElement = await li.$('a');
                    if (!linkElement) continue;

                    const gatuadressNamn = await linkElement.textContent();
                    const ratsitLink = await linkElement.getAttribute('href');

                    if (!gatuadressNamn || !ratsitLink) continue;

                    // Extract person count
                    const countElement = await li.$('.tree-structure__count');
                    let personerCount = 0;

                    if (countElement) {
                        const countText = await countElement.textContent();
                        const countMatch = countText.match(/\((\d+)\)/);
                        if (countMatch) {
                            personerCount = parseInt(countMatch[1]);
                        }
                    }

                    // Construct full URL if it's relative
                    const fullLink = ratsitLink.startsWith('http')
                        ? ratsitLink
                        : `https://www.ratsit.se${ratsitLink}`;

                    console.log(
                        `Found address: ${gatuadressNamn.trim()}, Count: ${personerCount}, Link: ${fullLink}`,
                    );

                    // Save to database
                    const saved = await saveAdressData(
                        postOrt,
                        postNummer,
                        gatuadressNamn.trim(),
                        personerCount,
                        fullLink,
                    );

                    if (saved) {
                        totalAddresses++;
                    }
                } catch (error) {
                    console.error(
                        'Error processing address item:',
                        error.message,
                    );
                }
            }
        }

        console.log(
            `Scraping completed successfully. Total addresses saved: ${totalAddresses}`,
        );
        await browser.close();
        return totalAddresses;
    } catch (error) {
        console.error('Error during scraping:', error);
        if (browser) {
            await browser.close();
        }
        return 0;
    }
}

// Get URL from command line argument
const url = process.argv[2];
const postOrt = process.argv[3];
const postNummer = process.argv[4];

if (!url || !postOrt || !postNummer) {
    console.error(
        'Please provide URL, post_ort, and post_nummer as arguments',
    );
    console.error(
        'Example: node ratsit_extract_adresser.mjs "https://www.ratsit.se/personer/..." "Trönödal" "82695"',
    );
    process.exit(1);
}

// Run scraper
scrapeRatsitAdresser(url, postOrt, postNummer).catch(console.error);
