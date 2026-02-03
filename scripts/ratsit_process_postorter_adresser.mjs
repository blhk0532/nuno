#!/usr/bin/env node
import { dirname, join } from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const projectRoot = join(__dirname, '..');

async function runExtractAdresserScript(postort) {
    try {
        console.log(
            `Running extract adresser script for: ${postort.post_ort} ${postort.post_nummer}`,
        );

        // Run the ratsit_extract_adresser.mjs script with the URL and post info
        const { exec } = await import('child_process');
        const { promisify } = await import('util');
        const execAsync = promisify(exec);

        const { stdout, stderr } = await execAsync(
            `node ${join(projectRoot, 'scripts/ratsit_extract_adresser.mjs')} "${postort.foretag_link}" "${postort.post_ort}" "${postort.post_nummer}"`,
            { timeout: 300000 }, // 5 minutes timeout
        );

        if (stderr) {
            console.error(
                `Script stderr for ${postort.post_ort} ${postort.post_nummer}:`,
                stderr,
            );
        }

        console.log(
            `Script output for ${postort.post_ort} ${postort.post_nummer}:`,
            stdout,
        );

        // Check if script ran successfully by looking for success indicators in output
        const successIndicators = [
            'Scraping completed successfully',
            'Saved address',
            'Total addresses saved',
        ];
        const wasSuccessful = successIndicators.some((indicator) =>
            stdout.toLowerCase().includes(indicator.toLowerCase()),
        );

        return wasSuccessful;
    } catch (error) {
        console.error(
            `Error running extract adresser script for ${postort.post_ort} ${postort.post_nummer}:`,
            error.message,
        );
        return false;
    }
}

async function updatePostortStatus(postortId, status) {
    try {
        const { exec } = await import('child_process');
        const { promisify } = await import('util');
        const execAsync = promisify(exec);

        // Use artisan tinker to update the database
        const { stdout, stderr } = await execAsync(
            `cd ${projectRoot} && php artisan tinker --execute="\\App\\Models\\RatsitPostorter::where('id', ${postortId})->update(['foretag_link_status' => ${status ? 1 : 0}]); echo 'Updated postort ID ${postortId} with foretag_link_status = ${status ? 1 : 0}';"`,
        );

        if (stderr) {
            console.error(`Update stderr for postort ID ${postortId}:`, stderr);
        }

        console.log(`Update result for postort ID ${postortId}:`, stdout);
    } catch (error) {
        console.error(
            `Error updating postort ID ${postortId}:`,
            error.message,
        );
    }
}

async function getPostorterWithPersonerLinks() {
    try {
        const { exec } = await import('child_process');
        const { promisify } = await import('util');
        const execAsync = promisify(exec);

        // Use artisan tinker to get the data
        const { stdout, stderr } = await execAsync(
            `cd ${projectRoot} && php artisan tinker --execute="
\\$postorter = \\App\\Models\\RatsitPostorter::whereNotNull('foretag_link')
    ->where('foretag_link', '!=', '')
    ->where('foretag_link_status', 0)
    ->get(['id', 'post_ort', 'post_nummer', 'foretag_count', 'foretag_link', 'foretag_link_status']);

foreach (\\$postorter as \\$postort) {
    echo json_encode([
        'id' => \\$postort->id,
        'post_ort' => \\$postort->post_ort,
        'post_nummer' => \\$postort->post_nummer,
        'foretag_count' => \\$postort->foretag_count,
        'foretag_link' => \\$postort->foretag_link,
        'foretag_link_status' => \\$postort->foretag_link_status
    ]) . PHP_EOL;
}"`,
        );

        if (stderr) {
            console.error('Get postorter stderr:', stderr);
        }

        const lines = stdout.trim().split('\n');
        const postorter = lines
            .filter((line) => line.trim())
            .map((line) => {
                try {
                    return JSON.parse(line);
                } catch (e) {
                    console.error('Failed to parse line:', line);
                    return null;
                }
            })
            .filter((postort) => postort !== null);

        return postorter;
    } catch (error) {
        console.error('Error getting postorter:', error.message);
        return [];
    }
}

async function main() {
    console.log('Starting Ratsit postorter address extraction batch processing...');

    try {
        // Get all postorter with foretag_link values from the database
        const postorter = await getPostorterWithPersonerLinks();

        console.log(
            `Found ${postorter.length} postorter with foretag_link values that need processing`,
        );

        // Process each postort
        for (const postort of postorter) {
            console.log(
                `\nProcessing postort: ${postort.post_ort} ${postort.post_nummer} (ID: ${postort.id})`,
            );
            console.log(
                `  Personer count: ${postort.foretag_count}, Link: ${postort.foretag_link}`,
            );

            // Skip if already processed successfully
            if (postort.foretag_link_status === 1) {
                console.log(
                    `Skipping ${postort.post_ort} ${postort.post_nummer} - already processed successfully`,
                );
                continue;
            }

            // Run the extract adresser script
            const success = await runExtractAdresserScript(postort);

            // Update the status in the database
            await updatePostortStatus(postort.id, success);

            // Add a small delay between requests to be respectful to the server
            await new Promise((resolve) => setTimeout(resolve, 2000));
        }

        console.log('\nBatch processing completed!');
    } catch (error) {
        console.error('Error in main process:', error);
        process.exit(1);
    }
}

// Run the main function
main().catch(console.error);
