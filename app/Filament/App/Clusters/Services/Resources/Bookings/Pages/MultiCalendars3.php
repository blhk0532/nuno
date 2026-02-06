<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Bookings\Pages;

use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar1;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar2;
use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar3;
use BackedEnum;
use Carbon\Carbon;
use Closure;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use UnitEnum;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;

final class MultiCalendars3 extends BaseDashboard
{
    //  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;

    protected static ?string $navigationLabel = 'Schema';

    protected static ?string $title = '';

    protected static string|UnitEnum|null $navigationGroup = '';

    protected static string $routePath = 'multi-calendars-3';

    // protected static string|BackedEnum|null $navigationIcon = Tabler::CalendarMonth;
    // protected static string|BackedEnum|null $activeNavigationIcon = Tabler::CalendarMonthF;
    protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarScheduleLine;

    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarScheduleFill;

    protected static ?int $navigationSort = 8;

    //  protected static ?string $slug = 'dashboard';

    protected string $view = 'filament.booking.pages.calendar-x3-booking';

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    // public static function getNavigationBadge(): ?string
    //  {
    //      return '🇹🇭 ' . now()->timezone('Asia/Bangkok')->format('H:i');
    //  }

    //    public static function getNavigationBadge(): ?string
    //    {
    //        Carbon::setLocale('sv');
    //        $day = now()
    //            ->timezone('Europe/Stockholm')
    //            ->translatedFormat('l');
    //
    //        return Str::ucfirst($day);
    //    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'gray';
    }

    public function getPermissionCheckClosure(): Closure
    {
        return fn (string $widgetClass) => true;
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
            'default' => 1, // optional base
            'sm' => 1,
            'md' => 1,
            'lg' => 1,
            'xl' => 3,
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
}
