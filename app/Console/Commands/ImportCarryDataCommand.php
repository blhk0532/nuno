<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCarryDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carry-data:import {file=carry_data.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import carry data from CSV file';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $file = $this->argument('file');
        $filePath = base_path($file);

        if (! file_exists($filePath)) {
            $this->error("File not found: {$filePath}");

            return self::FAILURE;
        }

        $this->info("Importing data from {$file}...");

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            $this->error('Failed to open file');

            return self::FAILURE;
        }

        // Read header line
        $header = fgetcsv($handle);
        if ($header === false) {
            $this->error('Failed to read header');
            fclose($handle);

            return self::FAILURE;
        }

        $this->info('Header: '.implode(', ', $header));

        // Truncate table before import
        if ($this->confirm('Do you want to truncate the carry_data table before import?', true)) {
            DB::table('carry_data')->truncate();
            $this->info('Table truncated.');
        }

        $batch = [];
        $batchSize = 1000;
        $totalImported = 0;
        $lineNumber = 1;

        $bar = $this->output->createProgressBar();
        $bar->start();

        while (($data = fgetcsv($handle)) !== false) {
            $lineNumber++;

            // Skip empty lines
            if (empty(array_filter($data))) {
                continue;
            }

            // Map CSV columns to database columns
            // Note: Header has Id column but data rows don't include it
            // Data column indices: 0=Personlöpnr, 1=Personnr, 2=Kön, 3=Civilstånd,
            // 4=Namn, 5=Förnamn, 6=Efternamn, 7=Adress, 8=CoAdress,
            // 9=Postnr, 10=Ort, 11=Telefon, 12=Mobiltelefon, 13=Telefax,
            // 14=Epost, 15=EpostPrivat, 16=EpostSekundär
            $batch[] = [
                'person_lopnr' => trim($data[0] ?? '') ?: null,
                'personnr' => trim($data[1] ?? '') ?: null,
                'kon' => trim($data[2] ?? '') ?: null,
                'civilstand' => trim($data[3] ?? '') ?: null,
                'namn' => trim($data[4] ?? '') ?: null,
                'fornamn' => trim($data[5] ?? '') ?: null,
                'efternamn' => trim($data[6] ?? '') ?: null,
                'adress' => trim($data[7] ?? '') ?: null,
                'co_adress' => trim($data[8] ?? '') ?: null,
                'postnr' => trim($data[9] ?? '') ?: null,
                'ort' => trim($data[10] ?? '') ?: null,
                'telefon' => trim($data[11] ?? '') ?: null,
                'mobiltelefon' => trim($data[12] ?? '') ?: null,
                'telefax' => trim($data[13] ?? '') ?: null,
                'epost' => trim($data[14] ?? '') ?: null,
                'epost_privat' => trim($data[15] ?? '') ?: null,
                'epost_sekundar' => trim($data[16] ?? '') ?: null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) >= $batchSize) {
                DB::table('carry_data')->insert($batch);
                $totalImported += count($batch);
                $bar->advance(count($batch));
                $batch = [];
            }
        }

        // Insert remaining records
        if (! empty($batch)) {
            DB::table('carry_data')->insert($batch);
            $totalImported += count($batch);
            $bar->advance(count($batch));
        }

        $bar->finish();
        $this->newLine(2);

        fclose($handle);

        $this->info("Successfully imported {$totalImported} records.");

        return self::SUCCESS;
    }
}
