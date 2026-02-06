<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('ringa_data')) {
            return;
        }

        // Map old outcome values to new ones
        $mappings = [
            'yes' => 'Bokad',
            'dmc' => '( DMC )',
            'no_answer' => 'Inget Svar',
            'voicemail' => 'Telefonsvar',
            'not_connected' => 'Ej Kopplat',
            'call_back' => 'Ring Tillbaka',
            'clicked' => 'Klickad',
            'not_interested' => 'Ej Intresse',
            'wrong_number' => 'Felnummer',
            'busy' => 'Upptagen',
            'recently_done' => 'Nyligen Gjort',
            'no' => 'Ej Intresse', // Map 'no' to 'Ej Intresse'
        ];

        foreach ($mappings as $old => $new) {
            DB::table('ringa_data')->where('outcome', $old)->update(['outcome' => $new]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('ringa_data')) {
            return;
        }

        // Reverse the mappings
        $reverseMappings = [
            'Bokad' => 'yes',
            '( DMC )' => 'dmc',
            'Inget Svar' => 'no_answer',
            'Telefonsvar' => 'voicemail',
            'Ej Kopplat' => 'not_connected',
            'Ring Tillbaka' => 'call_back',
            'Klickad' => 'clicked',
            'Ej Intresse' => 'not_interested',
            'Felnummer' => 'wrong_number',
            'Upptagen' => 'busy',
            'Nyligen Gjort' => 'recently_done',
        ];

        foreach ($reverseMappings as $new => $old) {
            DB::table('ringa_data')->where('outcome', $new)->update(['outcome' => $old]);
        }
    }
};
