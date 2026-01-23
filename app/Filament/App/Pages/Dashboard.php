<?php

namespace App\Filament\App\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Enums\Width;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar1;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar2;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar3;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'NDS Dashboard';

    protected static ?string $title = 'Min Dashboard';

     protected static ?string $slug = 'dashboard';

    protected static string|BackedEnum|null $navigationIcon = Remix::RiDashboard2Line;
    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiDashboard2Fill;

 //   protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarScheduleLine;
 //   protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarScheduleFill;

    protected static ?int $navigationSort = 3;

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

    public function getWidgets(): array
    {
        return [
            MultiCalendar1::class,
            MultiCalendar2::class,
            MultiCalendar3::class,
        ];
    }

       public static function getNavigationBadge(): ?string
    {
        return '🇹🇭 ' . now()->timezone('Asia/Bangkok')->format('H:i');
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }
}
