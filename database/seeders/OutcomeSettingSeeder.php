<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Outcomes;
use App\Models\OutcomeSetting;
use Illuminate\Database\Seeder;

final class OutcomeSettingSeeder extends Seeder
{
    public function run(): void
    {
        $outcomes = Outcomes::cases();

        foreach ($outcomes as $outcome) {
            OutcomeSetting::query()->updateOrCreate(
                ['outcome' => $outcome->name],
                [
                    'type' => $outcome->value,
                    'outcome' => $outcome->name,
                    'title' => $outcome->getLabel(),
                    'color' => $this->getHexColor($outcome->getColor()),
                    'icon' => $outcome->getIcon(),
                    'description' => $outcome->value,
                    'dmc' => $outcome->name === 'DMC',
                    'aterkom' => $outcome->name === 'Aterkommer',
                    'is_active' => true,
                ],
            );
        }
    }

    private function getHexColor(string $color): string
    {
        $colorMap = [
            'danger' => '#dc2626',
            'primary' => '#2563eb',
            'warning' => '#f59e0b',
            'success' => '#16a34a',
            'gray' => '#6b7280',
        ];

        return $colorMap[$color] ?? '#000000';
    }
}
