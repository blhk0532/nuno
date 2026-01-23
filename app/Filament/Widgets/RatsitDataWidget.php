<?php

namespace App\Filament\Widgets;

use App\Models\RatsitData;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class RatsitDataWidget extends BaseWidget
{
    protected static bool $isDiscovered = false;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalRecords = RatsitData::count();
        $activeRecords = RatsitData::where('is_active', true)->count();
        $telefonRecords = RatsitData::where('is_telefon', true)->count();
        $husRecords = RatsitData::where('is_hus', true)->count();

        return [
            Stat::make('Total Records', Number::format($totalRecords))
                ->description('Total RatsitData records')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Active Records', Number::format($activeRecords))
                ->description('Currently active records')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Phone Records', Number::format($telefonRecords))
                ->description('Records with phone data')
                ->descriptionIcon('heroicon-m-phone')
                ->color('info'),

            Stat::make('House Records', Number::format($husRecords))
                ->description('Records with house data')
                ->descriptionIcon('heroicon-m-home')
                ->color('warning'),
        ];
    }
}
