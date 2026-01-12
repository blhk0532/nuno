<?php

namespace App\Console\Commands;

use App\Models\RatsitData;
use Illuminate\Console\Command;

class UpdateRatsitIsQueuedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratsit-data:update-is-queued';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update is_queued column in ratsit_data table based on gatuadress field pattern';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting to update is_queued column in ratsit_data...');

        // Pattern that indicates it's NOT a house (lgh, tr, nb, box, bv, number + letter patterns)
        $isHusFalsePattern = '/lgh|1 tr|2 tr|3 tr|4 tr|5 tr|6 tr| nb| box| bv|\b([1-9][0-9]?|100) [A-Z]\b/i';

        $totalRecords = RatsitData::count();
        $this->info("Total records to process: {$totalRecords}");

        $bar = $this->output->createProgressBar($totalRecords);
        $bar->start();

        $updatedToFalse = 0;
        $updatedToTrue = 0;
        $skipped = 0;

        // Process in chunks to avoid memory issues
        RatsitData::chunk(1000, function ($records) use ($isHusFalsePattern, &$updatedToFalse, &$updatedToTrue, &$skipped, $bar) {
            foreach ($records as $record) {
                if (empty($record->gatuadress)) {
                    // If gatuadress is empty, skip or set to null
                    $skipped++;
                } elseif (preg_match($isHusFalsePattern, $record->gatuadress)) {
                    // If gatuadress matches the pattern, it's NOT a house - set is_queued = 0
                    $record->update(['is_queued' => false]);
                    $record->update(['is_hus' => false]);
                    $record->update(['is_active' => false]);
                    $updatedToFalse++;
                } else {
                    // If gatuadress doesn't match the pattern, it IS a house - set is_queued = 1
                    $record->update(['is_queued' => true]);
                    $record->update(['is_hus' => true]);
                    $record->update(['is_active' => true]);
                    $updatedToTrue++;
                }

                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine(2);

        $this->info('Update completed!');
        $this->info("Records set to is_queued = 0 (not house): {$updatedToFalse}");
        $this->info("Records set to is_queued = 1 (house): {$updatedToTrue}");
        $this->info("Records skipped (empty gatuadress): {$skipped}");

        return Command::SUCCESS;
    }
}
