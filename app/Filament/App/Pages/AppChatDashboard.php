<?php

namespace App\Filament\App\Pages;

use Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Widgets\BookingCalendar;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use UnitEnum;

// use Dotswan\FilamentLaravelPulse\Widgets\PulseCache;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseExceptions;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseQueues;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseServers;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowOutGoingRequests;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowQueries;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseSlowRequests;
// use Dotswan\FilamentLaravelPulse\Widgets\PulseUsage;

class AppChatDashboard extends BaseDashboard
{
    protected static ?string $title = '';

    protected static ?string $slug = 'wirechat';

    protected string $view = 'filament.app.chat-dashboard';

    protected static ?string $navigationLabel = 'Meddelanden';

     protected static string | UnitEnum | null $navigationGroup = 'Mina Sidor';

    protected static ?int $navigationSort = 20;

    protected static ?int $sort = 0;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartPie;

    // Prevent this app-level Dashboard from being auto-discovered so that
    // the explicit `AdminDashboard` can be registered as the admin panel root.
    protected static bool $isDiscovered = false;

    public function getColumns(): int
    {
        // Use fewer columns so widgets are wider and not visually compressed.
        return 2;
    }

    public function getWidgets(): array
    {
        return [
            BookingCalendar::class,
            \App\Filament\App\Widgets\StatsOverviewWidget::class,
            \App\Filament\App\Widgets\OrdersChart::class,
            \App\Filament\App\Widgets\CustomersChart::class,
            \App\Filament\App\Widgets\LatestOrders::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderTitle(): string
    {
        return false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return 'Meddelanden';
    }

    public static function getNavigationBadge(): ?string
    {
        return 0;

    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-s-chat-bubble-oval-left-ellipsis';
    }

    public static function getNavigationSort(): ?int
    {
        return 20;
    }

    public static function getSort(): ?int
    {
        return 20;
    }
}
