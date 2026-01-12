<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RestoreTelefon extends Command
{
    protected $signature = 'restore:telefon';

    protected $description = 'Restore telefon values from backup file to merinfo_data table';

    public function handle(): int
    {
        $backupPath = storage_path('app/backups/backup_filament_2025-12-03_21-59-18.sql');

        if (! file_exists($backupPath)) {
            $this->error("Backup file not found at: $backupPath");

            return 1;
        }

        $this->info('📂 Reading backup file...');
        $content = file_get_contents($backupPath);

        // Extract ALL merinfo_data INSERT statements
        $pattern = '/INSERT INTO `merinfo_data` VALUES \(([^;]+)\);/s';

        if (! preg_match_all($pattern, $content, $matches)) {
            $this->error('❌ Could not find merinfo_data INSERT statement');

            return 1;
        }

        // Combine all VALUES content from all INSERT statements
        $valuesContent = implode('),(', $matches[1]);
        $this->info('✅ Found '.count($matches[1]).' merinfo_data INSERT statements');

        // Parse records
        $records = $this->extractRecordTuples($valuesContent);
        $this->info('📊 Parsed '.count($records).' records from backup');

        if (count($records) === 0) {
            $this->error('❌ No records extracted');

            return 1;
        }

        // Process each record
        $updates = [];
        $sample = [];
        $nullCount = 0;
        $emptyArrayCount = 0;

        foreach ($records as $index => $record) {
            $fields = $this->parseRecordFields($record);

            if (count($fields) < 8) {
                continue;
            }

            $id = trim($fields[0]);
            if (! is_numeric($id)) {
                continue;
            }

            $id = (int) $id;

            // Column 7 is telefon (0-indexed, so field[7])
            // Current table structure: id(0), personnamn(1), alder(2), kon(3), gatuadress(4), postnummer(5), postort(6), telefon(7)
            $telefon_json = isset($fields[7]) ? $fields[7] : '[]';

            // Track stats
            if ($telefon_json === 'NULL') {
                $nullCount++;
            } elseif ($telefon_json === '[]') {
                $emptyArrayCount++;
            }

            // Extract phone from JSON array
            $phone = $this->extractPhoneFromJsonArray($telefon_json);

            if ($phone !== null) {
                $updates[$id] = $phone;

                if (count($sample) < 5) {
                    $sample[] = "ID $id: $telefon_json → $phone";
                }
            }
        }

        $this->info('📋 Extracted '.count($updates).' records with telefon values');
        $this->info("   NULL values: $nullCount");
        $this->info("   Empty arrays: $emptyArrayCount");
        $this->info('   Total records processed: '.count($records));

        if (count($sample) > 0) {
            $this->newLine();
            $this->info('✅ Sample extracted records:');
            foreach ($sample as $s) {
                $this->line("  $s");
            }
            $this->newLine();
        }

        // Update database
        if (count($updates) > 0) {
            $this->info('💾 Updating database...');

            $successCount = 0;
            $failCount = 0;

            foreach ($updates as $id => $phone) {
                try {
                    DB::table('merinfo_data')
                        ->where('id', $id)
                        ->update(['telefon' => $phone]);
                    $successCount++;
                } catch (Exception $e) {
                    $failCount++;
                }
            }

            $this->info("✅ Successfully updated $successCount records");
            if ($failCount > 0) {
                $this->warn("⚠️  Failed to update $failCount records");
            }
        }

        $this->info('✅ Restore complete!');

        return 0;
    }

    /**
     * Extract individual record tuples from VALUES clause
     */
    private function extractRecordTuples(string $content): array
    {
        $records = [];
        $currentRecord = '';
        $inString = false;
        $inJson = false;
        $escaped = false;

        for ($i = 0; $i < strlen($content); $i++) {
            $char = $content[$i];
            $nextChar = $i + 1 < strlen($content) ? $content[$i + 1] : '';

            // Handle escape sequences
            if ($escaped) {
                $currentRecord .= $char;
                $escaped = false;

                continue;
            }

            if ($char === '\\') {
                $escaped = true;
                $currentRecord .= $char;

                continue;
            }

            // Track string state (single quotes)
            if ($char === "'" && ! $inJson) {
                $inString = ! $inString;
                $currentRecord .= $char;

                continue;
            }

            // Track JSON array state
            if ($char === '[' && ! $inString) {
                $inJson = true;
                $currentRecord .= $char;

                continue;
            }
            if ($char === ']' && ! $inString) {
                $inJson = false;
                $currentRecord .= $char;

                continue;
            }

            // Look for record boundary: ),( outside of strings/JSON
            if ($char === ')' && ! $inString && ! $inJson && $nextChar === ',') {
                // End of this record
                if (! empty($currentRecord)) {
                    $records[] = $currentRecord;
                }
                $currentRecord = '';
                $i++; // Skip the comma
                // Skip the opening paren of next record if present
                if ($i + 1 < strlen($content) && $content[$i + 1] === '(') {
                    $i++;
                }

                continue;
            }

            $currentRecord .= $char;
        }

        // Handle the last record (may end with ); instead of ),)
        if (! empty($currentRecord)) {
            $records[] = rtrim($currentRecord, ');');
        }

        return $records;
    }

    /**
     * Parse CSV-like fields from record, handling strings, JSON, and multiline records
     */
    private function parseRecordFields(string $record): array
    {
        $record = trim($record);

        // Remove outer parens if present: (123,'value') => 123,'value'
        if (str_starts_with($record, '(') && str_ends_with($record, ')')) {
            $record = substr($record, 1, -1);
        }

        // Use PHP's str_getcsv with single quote as the enclosure character
        // This properly handles SQL-style quoting: 'value','another'
        $fields = str_getcsv($record, ',', "'");

        return $fields;
    }

    /**
     * Extract phone number from JSON array format
     * Handles: ["value"], ["+46707324056"], [], etc.
     * The data can have escaped quotes: [\"+46...\"]
     */
    private function extractPhoneFromJsonArray(string $value): ?string
    {
        $value = trim($value);

        // Remove outer single quotes if present (from SQL)
        if ((str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            $value = substr($value, 1, -1);
        }

        if ($value === '[]' || empty($value)) {
            return null;
        }

        // Handle escaped quotes from backup: [\"+46707324056\"]
        // First try to match the full escaped pattern
        if (preg_match('/^\[\s*\\"([^"]+)\\"\s*\]$/', $value, $m)) {
            return $m[1];
        }

        // Handle unescaped quotes: ["+46707324056"]
        if (preg_match('/^\[\s*"([^"]+)"\s*\]$/', $value, $m)) {
            return $m[1];
        }

        // Handle bare values: [+46707324056]
        if (preg_match('/^\[\s*([^\]]+)\s*\]$/', $value, $m)) {
            $inner = trim($m[1], ' "\'\\');
            if (! empty($inner) && $inner !== 'NULL') {
                return $inner;
            }
        }

        // Fallback for quoted strings
        if (preg_match('/^"([^"]+)"$/', $value, $m)) {
            return $m[1];
        }

        if (! empty($value) && $value !== 'NULL') {
            return $value;
        }

        return null;
    }
}
