<?php

namespace App\Filament\App\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Enums\Width;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar1;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar2;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar3;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\SingleCalendars;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;
use Wallacemartinss\FilamentIconPicker\Enums\Heroicons;
use Wallacemartinss\FilamentIconPicker\Enums\BootstrapIcons;
use App\Filament\App\Widgets\AccountInfoStackWidget;
use App\Filament\App\Widgets\WorldClockWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Arshaviras\WeatherWidget\Widgets\WeatherWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataTableWidget;
use UnitEnum;

class Dashboard extends BaseDashboard
{
   // protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'dashboard';

     protected static ?string $slug = 'dashboard';

 // protected static string|BackedEnum|null $navigationIcon = Tabler::CalendarMonthF;
    protected static string|BackedEnum|null $navigationIcon = BootstrapIcons::PersonCheck;
    protected static string|BackedEnum|null $activeNavigationIcon = BootstrapIcons::PersonFillCheck;


 //   protected static string|BackedEnum|null $navigationIcon = Remix::RiDashboard2Line;
 //   protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiDashboard2Fill;

 //   protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarScheduleLine;
 //   protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarScheduleFill;

 //  protected static string|UnitEnum|null $navigationGroup = '';
    protected static ?int $navigationSort = -1;


        public static function getNavigationLabel(): string
    {
        return ''.Str::ucfirst(Auth::user()->name) ?? 'User';
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    public function getWidgetsColumns(): int | array
    {
        return 1;
    }

    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'sm'  => 1,
            'md'  => 1,
            'lg'  => 1,
            'xl'  => 3,
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
             \App\Filament\App\Widgets\LatestOrders::class,
            SingleCalendars::class,

        //    MultiCalendar1::class,
            MultiCalendar2::class,
            MultiCalendar3::class,
        ];
    }
    public function getWidgets(): array
    {
        return [
        //    RingaDataTableWidget::class,
             WeatherWidget::class,
        //    \App\Filament\App\Widgets\OrdersChart::class,
       //     \App\Filament\App\Widgets\CustomersChart::class,
        //    SingleCalendars::class,
        //    MultiCalendar1::class,
        //    MultiCalendar2::class,
        //    MultiCalendar3::class,
        ];
    }

      public static function getNavigationBadge(): ?string
      {
          return '🇹🇭 ' . now()->timezone('Asia/Bangkok')->format('H:i');
      }
      public static function getNavigationBadgeColor(): ?string
      {
          return 'gray';
      }
}
