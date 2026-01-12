<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Normalize kommun names by removing " kommun" suffix and merge duplicates
        // Find all pairs where one version has " kommun" suffix and one doesn't
        DB::transaction(function () {
            // Get all kommuner ending with " kommun"
            $kommunerWithSuffix = DB::table('ratsit_kommuner')
                ->where('kommun', 'like', '% kommun')
                ->get();

            foreach ($kommunerWithSuffix as $withSuffix) {
                // Remove " kommun" suffix to find the base name
                $baseName = preg_replace('/ kommun$/', '', $withSuffix->kommun);

                // Check if there's a matching record without the suffix
                $withoutSuffix = DB::table('ratsit_kommuner')
                    ->where('kommun', $baseName)
                    ->first();

                if ($withoutSuffix) {
                    // Merge the data: combine counts and links
                    DB::table('ratsit_kommuner')
                        ->where('kommun', $baseName)
                        ->update([
                            'personer_count' => ($withoutSuffix->personer_count ?? 0) + ($withSuffix->personer_count ?? 0),
                            'foretag_count' => ($withoutSuffix->foretag_count ?? 0) + ($withSuffix->foretag_count ?? 0),
                            'personer_link' => $withoutSuffix->personer_link ?? $withSuffix->personer_link,
                            'foretag_link' => $withoutSuffix->foretag_link ?? $withSuffix->foretag_link,
                            'updated_at' => now(),
                        ]);

                    // Delete the duplicate with " kommun" suffix
                    DB::table('ratsit_kommuner')
                        ->where('kommun', $withSuffix->kommun)
                        ->delete();
                } else {
                    // No duplicate found, just normalize the name by removing suffix
                    DB::table('ratsit_kommuner')
                        ->where('kommun', $withSuffix->kommun)
                        ->update([
                            'kommun' => $baseName,
                            'updated_at' => now(),
                        ]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is a data fix, cannot be reversed
        // Would require storing the original kommun names before normalization
    }
};
