<?php

namespace App\Filament\App\Widgets;

use Adultdate\FilamentBooking\Models\Booking\Booking;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    use InteractsWithPageFilters;
protected static bool $isDiscovered = false;
    protected static ?int $sort = 10;

    protected function getStats(): array
    {

        $startDate = ! is_null($this->pageFilters['startDate'] ?? null) ?
            Carbon::parse($this->pageFilters['startDate']) :
            null;

        $endDate = ! is_null($this->pageFilters['endDate'] ?? null) ?
            Carbon::parse($this->pageFilters['endDate']) :
            now();

        $isBusinessCustomersOnly = $this->pageFilters['businessCustomersOnly'] ?? null;
        $businessCustomerMultiplier = match (true) {
            boolval($isBusinessCustomersOnly) => 2 / 3,
            blank($isBusinessCustomersOnly) => 1,
            default => 1 / 3,
        };

        $diffInDays = $startDate ? $startDate->diffInDays($endDate) : 0;

        // Booking counts for the current authenticated user.
        $userId = Auth::id();

        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $bookingsToday = $userId ? Booking::query()
            ->where(function ($q) use ($userId) {
                $q->where('booking_user_id', $userId)
                    ->orWhere('service_user_id', $userId);
            })
            ->where(function ($q) use ($today) {
                $q->whereDate('service_date', $today->toDateString())
                    ->orWhereDate('starts_at', $today->toDateString());
            })
            ->count() : 0;

        $bookingsThisWeek = $userId ? Booking::query()
            ->where(function ($q) use ($userId) {
                $q->where('booking_user_id', $userId)
                    ->orWhere('service_user_id', $userId);
            })
            ->where(function ($q) use ($weekStart, $weekEnd) {
                $q->whereBetween('service_date', [$weekStart->toDateString(), $weekEnd->toDateString()])
                    ->orWhereBetween('starts_at', [$weekStart->toDateString(), $weekEnd->toDateString()]);
            })
            ->count() : 0;

        $bookingsThisMonth = $userId ? Booking::query()
            ->where(function ($q) use ($userId) {
                $q->where('booking_user_id', $userId)
                    ->orWhere('service_user_id', $userId);
            })
            ->where(function ($q) use ($monthStart, $monthEnd) {
                $q->whereBetween('service_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
                    ->orWhereBetween('starts_at', [$monthStart->toDateString(), $monthEnd->toDateString()]);
            })
            ->count() : 0;

        $completedToday = $userId ? Booking::query()
            ->where(function ($q) use ($userId) {
                $q->where('booking_user_id', $userId)
                    ->orWhere('service_user_id', $userId);
            })
            ->where(function ($q) use ($today) {
                $q->whereDate('service_date', $today->toDateString())
                    ->orWhereDate('starts_at', $today->toDateString());
            })
            ->where('status', 'completed')
            ->count() : 0;

        $completedThisWeek = $userId ? Booking::query()
            ->where(function ($q) use ($userId) {
                $q->where('booking_user_id', $userId)
                    ->orWhere('service_user_id', $userId);
            })
            ->where(function ($q) use ($weekStart, $weekEnd) {
                $q->whereBetween('service_date', [$weekStart->toDateString(), $weekEnd->toDateString()])
                    ->orWhereBetween('starts_at', [$weekStart->toDateString(), $weekEnd->toDateString()]);
            })
            ->where('status', 'completed')
            ->count() : 0;

        $completedThisMonth = $userId ? Booking::query()
            ->where(function ($q) use ($userId) {
                $q->where('booking_user_id', $userId)
                    ->orWhere('service_user_id', $userId);
            })
            ->where(function ($q) use ($monthStart, $monthEnd) {
                $q->whereBetween('service_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
                    ->orWhereBetween('starts_at', [$monthStart->toDateString(), $monthEnd->toDateString()]);
            })
            ->where('status', 'completed')
            ->count() : 0;

        $formatNumber = function (int $number): string {
            if ($number < 1000) {
                return (string) Number::format($number, 0);
            }

            if ($number < 1000000) {
                return Number::format($number / 1000, 2).'k';
            }

            return Number::format($number / 1000000, 2).'m';
        };

        return [
            Stat::make('Bookings', (string) $formatNumber($bookingsToday))
                ->description('Bookings today')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->chart([5, 5, 5, 5, 5, 5, 5])
                ->color('success'),

            Stat::make('Complete', $formatNumber($completedThisWeek))
                ->description('Completed this week')
                ->descriptionIcon('heroicon-o-check-badge')
                ->chart([5, 5, 5, 5, 5, 5, 5])
                ->color('primary'),

            Stat::make('Success rate', $formatNumber($completedThisMonth > 0 && $bookingsThisMonth > 0 ? (int) round(($completedThisMonth / $bookingsThisMonth) * 100) : 0).'%')
                ->description('Success rate this month')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->chart([5, 5, 5, 5, 5, 5, 5])
                ->color('success'),
        ];
    }
}
