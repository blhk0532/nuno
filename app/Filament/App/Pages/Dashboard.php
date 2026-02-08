<?php

declare(strict_types=1);

namespace App\Filament\App\Pages;

use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar1;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar2;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar3;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\SingleCalendars;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataTableWidget;
use App\Filament\App\Widgets\AccountInfoStackWidget;
use App\Filament\App\Widgets\WorldClockWidget;
use Arshaviras\WeatherWidget\Widgets\WeatherWidget;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use UnitEnum;
use Wallacemartinss\FilamentIconPicker\Enums\BootstrapIcons;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;

final class Dashboard extends BaseDashboard
{
    // protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'dashboard';

    protected static ?string $slug = 'dashboard';

    // protected static string|BackedEnum|null $navigationIcon = Tabler::CalendarMonthF;
    //   protected static string|BackedEnum|null $navigationIcon = BootstrapIcons::PersonCheck;
    //   protected static string|BackedEnum|null $activeNavigationIcon = BootstrapIcons::PersonFillCheck;

    protected static string|BackedEnum|null $navigationIcon = Remix::RiShieldUserLine;

    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiShieldUserFill;

    //   protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarScheduleLine;
    //   protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarScheduleFill;

    //  protected static string|UnitEnum|null $navigationGroup = ' ';
    protected static ?int $navigationSort = -2;

    public static function getNavigationLabel(): string
    {
        return ''.Str::ucfirst(Auth::user()->name) ?? 'User';
    }

    public static function getNavigationBadge(): ?string
    {
        return '❍nline';

    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    public function getWidgetsColumns(): int|array
    {
        return 1;
    }

    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'sm' => 1,
            'md' => 1,
            'lg' => 1,
            'xl' => 3,
            '2xl' => 3,
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            AccountInfoStackWidget::class,
            WorldClockWidget::class,

            //    \App\Filament\App\Widgets\LatestOrders::class,
            //    \App\Filament\App\Widgets\StatsOverviewWidget::class,

            //    MultiCalendar1::class,
            //    MultiCalendar2::class,
            //    MultiCalendar3::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            //    RingaDataTableWidget::class,
            \App\Filament\App\Widgets\LatestOrders::class,
            //    \App\Filament\App\Widgets\OrdersChart::class,
            //    \App\Filament\App\Widgets\CustomersChart::class,
            //    SingleCalendars::class,
            //    MultiCalendar1::class,
            //    MultiCalendar2::class,
            //    MultiCalendar3::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            SingleCalendars::class,
            //    WeatherWidget::class,
        ];
    }
}
