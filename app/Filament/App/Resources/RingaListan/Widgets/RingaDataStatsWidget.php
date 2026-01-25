<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaListan\Widgets;

use App\Models\RingaData;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

final class RingaDataStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = -1;

    protected int|string|array $columnSpan = 12;

    protected function getStats(): array
    {
        $connection = (new RingaData)->getConnectionName() ?: config('database.default');
        $driver = config('database.connections.'.$connection.'.driver');
        // Count records with phone (check actual telefon field, not just is_telefon flag)
        $telefonCount = RingaData::where(function ($query) use ($driver) {
            $query->whereNotNull('telefon');

            if ($driver === 'pgsql') {
                $query->whereRaw('telefon::text <> ?', ['[]'])
                    ->whereRaw('telefon::text <> ?', ['""'])
                    ->whereRaw('telefon::text <> ?', ['{}']);

                return;
            }

            $query->where('telefon', '!=', '[]')
                ->where('telefon', '!=', '""')
                ->where('telefon', '!=', '{}');
        })->count();

        // Count sum of all attempts in the list
        $attemptCount = (int) RingaData::sum('attempts');

        // Count records with outcome is not null
        $outcomes = (int) RingaData::whereNotNull('outcome')->count();

        // Count records with booking_id not null
        $bookings = (int) RingaData::whereNotNull('booking_id')->count();

        return [
            Stat::make('Ringlista', number_format($telefonCount))
                ->description('Nummer Ringlista')
                ->color('success')
                ->icon('heroicon-o-phone'),

            Stat::make('Attempts', number_format($attemptCount))
                ->description('Totala försök')
                ->color('primary')
                ->icon('heroicon-o-phone-arrow-up-right'),

            Stat::make('Outcomes', number_format($outcomes))
                ->description('Avslutade samtal')
                ->color('warning')
                ->icon('heroicon-o-check-badge'),

            Stat::make('Booking', number_format($bookings))
                ->description('Bokningar')
                ->color('gray')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
