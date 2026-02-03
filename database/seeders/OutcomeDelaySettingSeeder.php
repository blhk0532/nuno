<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\OutcomeDelaySetting;
use Illuminate\Database\Seeder;

final class OutcomeDelaySettingSeeder extends Seeder
{
    public function run(): void
    {
        $outcomes = [
            ['outcome' => 'EjFramkopplad', 'delay_minutes' => 60, 'description' => 'Not connected - retry in 1 hour'],
            ['outcome' => 'Upptagen', 'delay_minutes' => 30, 'description' => 'Busy - retry in 30 minutes'],
            ['outcome' => 'Voicemail', 'delay_minutes' => 120, 'description' => 'Voicemail - retry in 2 hours'],
            ['outcome' => 'IngetSvar', 'delay_minutes' => 45, 'description' => 'No answer - retry in 45 minutes'],
        ];

        foreach ($outcomes as $data) {
            OutcomeDelaySetting::updateOrCreate(
                ['outcome' => $data['outcome']],
                $data
            );
        }
    }
}
