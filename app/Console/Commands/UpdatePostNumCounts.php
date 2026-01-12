<?php

namespace App\Console\Commands;

use App\Models\HittaData;
use App\Models\PostNum;
use Exception;
use Illuminate\Console\Command;

class UpdatePostNumCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postnum:update-counts {--post-ort= : Specific post ort to update} {--all : Update all post orter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update PostNum hitta_personer_saved counts from hitta_data table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('all')) {
            $this->info('Updating counts for all PostNums...');
            $postNums = PostNum::all();
        } elseif ($this->option('post-ort')) {
            $postOrt = $this->option('post-ort');
            $this->info("Updating counts for PostOrt: {$postOrt}");
            $postNums = PostNum::where('post_ort', $postOrt)->get();
        } else {
            $this->error('Please specify either --all or --post-ort=<name>');

            return self::FAILURE;
        }

        if ($postNums->isEmpty()) {
            $this->warn('No PostNums found to update.');

            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($postNums->count());
        $bar->start();

        $updated = 0;
        foreach ($postNums as $postNum) {
            try {
                $postNummer = $postNum->post_nummer;

                // Count total records for this postnummer
                $totalCount = HittaData::where('postnummer', $postNummer)->count();

                // Count records with phone numbers
                $phoneCount = HittaData::where('postnummer', $postNummer)
                    ->where('is_telefon', true)
                    ->count();

                // Count records that are houses
                $houseCount = HittaData::where('postnummer', $postNummer)
                    ->where('is_hus', true)
                    ->count();

                $postNum->update([
                    'hitta_personer_saved' => $totalCount,
                    'hitta_personer_phone_saved' => $phoneCount,
                    'hitta_personer_house_saved' => $houseCount,
                ]);

                $updated++;
            } catch (Exception $e) {
                $this->error("\nFailed to update {$postNum->post_nummer}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✓ Updated counts for {$updated} PostNum(s)");

        return self::SUCCESS;
    }
}
