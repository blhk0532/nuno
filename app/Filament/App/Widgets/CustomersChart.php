<?php

namespace App\Filament\App\Widgets;

use Adultdate\FilamentBooking\Models\Booking\Booking;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class CustomersChart extends ChartWidget
{
    protected ?string $heading = 'Bokningar totalt';

    protected static ?int $sort = 12;

    /// protected int|string|array $columnSpan = 'full';


    protected static bool $isDiscovered = false;

    protected function getMaxHeight(): ?string
    {
        return '500';
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $year = Carbon::now()->year;
        $data = [];

        $userId = Auth::id();

        for ($month = 1; $month <= 12; $month++) {
            $query = Booking::query()
                ->where(function ($q) use ($year, $month) {
                    $q->whereYear('service_date', $year)
                        ->whereMonth('service_date', $month)
                        ->orWhere(function ($q2) use ($year, $month) {
                            $q2->whereYear('starts_at', $year)
                                ->whereMonth('starts_at', $month);
                        });
                });

            if ($userId) {
                $query->where(function ($q) use ($userId) {
                    $q->where('booking_user_id', $userId)
                        ->orWhere('service_user_id', $userId);
                });
            }

            $data[] = (int) $query->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Bokningar totalt',
                    'data' => $data,
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
