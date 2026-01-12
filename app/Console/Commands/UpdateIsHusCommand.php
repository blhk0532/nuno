<?php

namespace App\Console\Commands;

use App\Models\CarryData;
use Illuminate\Console\Command;

class UpdateIsHusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carry-data:update-is-hus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update is_hus column in carry_data table based on adress field pattern';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting to update is_hus column...');

        // Pattern that indicates it's NOT a house (lgh, tr, nb, box, bv, number + letter patterns)
        $isHusFalsePattern = '/lgh|1 tr|2 tr|3 tr|4 tr|5 tr|6 tr| nb| box| bv|\b([1-9][0-9]?|100) [A-Z]\b/i';

        $totalRecords = CarryData::count();
        $this->info("Total records to process: {$totalRecords}");

        $bar = $this->output->createProgressBar($totalRecords);
        $bar->start();

        $updatedToFalse = 0;
        $updatedToTrue = 0;

        // Process in chunks to avoid memory issues
        CarryData::chunk(1000, function ($records) use ($isHusFalsePattern, &$updatedToFalse, &$updatedToTrue, $bar) {
            foreach ($records as $record) {
                if (empty($record->adress)) {
                    // If adress is empty, set is_hus to null
                    $record->update(['is_hus' => null]);
                } elseif (preg_match($isHusFalsePattern, $record->adress)) {
                    // If adress matches the pattern, it's NOT a house
                    $record->update(['is_hus' => false]);
                    $updatedToFalse++;
                } else {
                    // If adress doesn't match the pattern, it IS a house
                    $record->update(['is_hus' => true]);
                    $updatedToTrue++;
                }

                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine(2);

        $this->info('Update completed!');
        $this->info("Records set to is_hus = 0 (not house): {$updatedToFalse}");
        $this->info("Records set to is_hus = 1 (house): {$updatedToTrue}");

        return Command::SUCCESS;
    }
}
