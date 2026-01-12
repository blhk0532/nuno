<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCarryDataIsHus extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'carry-data:update-is-hus';

    /**
     * The console command description.
     */
    protected $description = 'Set is_hus based on adress using isHusFalse regex (optimized with bulk updates)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting bulk update of is_hus column...');

        $startTime = microtime(true);
        $totalRecords = DB::table('carry_data')->count();
        $this->info("Total records: {$totalRecords}");

        // Pattern that indicates it's NOT a house
        $pattern = 'lgh| Lgh | 1 tr|2 tr|3 tr|4 tr|5 tr|6 tr| nb| box| bv|\\b([1-9][0-9]?|100) [A-Z]\\b';

        // Bulk update: Set is_hus = 0 for addresses matching the pattern (NOT houses)
        $this->info('Updating apartments/non-houses (is_hus = 0)...');
        $updatedFalse = DB::table('carry_data')
            ->where('adress', 'REGEXP', $pattern)
            ->update(['is_hus' => 0]);

        // Bulk update: Set is_hus = 1 for addresses NOT matching the pattern (houses)
        $this->info('Updating houses (is_hus = 1)...');
        $updatedTrue = DB::table('carry_data')
            ->where('adress', 'NOT REGEXP', $pattern)
            ->whereNotNull('adress')
            ->where('adress', '!=', '')
            ->update(['is_hus' => 1]);

        $duration = round(microtime(true) - $startTime, 2);

        $this->newLine();
        $this->components->info("Completed in {$duration} seconds!");
        $this->components->info("Houses (is_hus = 1): {$updatedTrue}");
        $this->components->info("Apartments/Non-houses (is_hus = 0): {$updatedFalse}");
        $this->components->info('Total updated: '.($updatedTrue + $updatedFalse));

        return self::SUCCESS;
    }
}
