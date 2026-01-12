<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ImportRatsitData extends Command
{
    protected $signature = 'ratsit:import {--streets} {--persons} {--all}';

    protected $description = 'Import Ratsit scraped data into database';

    public function handle()
    {
        $streets = $this->option('streets') || $this->option('all');
        $persons = $this->option('persons') || $this->option('all');

        if (! $streets && ! $persons) {
            $this->error('Please specify --streets, --persons, or --all');

            return 1;
        }

        if ($streets) {
            $this->importStreets();
        }

        if ($persons) {
            $this->importPersons();
        }

        return 0;
    }

    private function importStreets()
    {
        $path = base_path('python3/ratsit_streets_export.csv');

        if (! file_exists($path)) {
            $this->error("File not found: $path");

            return;
        }

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $count = 0;
        foreach ($csv->getRecords() as $record) {
            DB::table('ratsit_streets')->insertOrIgnore([
                'street_name' => $record['gata_namn'],
                'person_count' => (int) $record['persons_count'],
                'postal_code' => $record['post_nummer'],
                'city' => $record['post_ort'],
                'url' => $record['gata_url'],
                'scraped_at' => $record['scraped_at'],
            ]);
            $count++;
        }

        $this->info("✓ Imported $count streets");
    }

    private function importPersons()
    {
        $path = base_path('python3/ratsit_persons_export.csv');

        if (! file_exists($path)) {
            $this->error("File not found: $path");

            return;
        }

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $count = 0;
        foreach ($csv->getRecords() as $record) {
            DB::table('ratsit_persons')->insertOrIgnore([
                'name' => $record['namn'],
                'age' => $record['alder'] ? (int) $record['alder'] : null,
                'street' => $record['gata'],
                'postal_code' => $record['post_nummer'],
                'city' => $record['post_ort'],
                'url' => $record['ratsit_url'],
                'scraped_at' => $record['scraped_at'],
            ]);
            $count++;
        }

        $this->info("✓ Imported $count persons");
    }
}
