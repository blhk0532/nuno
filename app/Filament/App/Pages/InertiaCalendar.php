<?php

declare(strict_types=1);

namespace App\Filament\App\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use UnitEnum;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;

final class InertiaCalendar extends Page
{
    protected string $view = 'filament.booking.pages.inertia-calendar';
    //  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;
    // protected static string|BackedEnum|null $navigationIcon = 'heroicon-c-clipboard-document-check';

    protected static ?string $navigationLabel = 'Schema';

    protected static ?string $title = '';

    protected static ?int $navigationSort = 6;

    protected static ?int $sort = 6;

    protected static ?string $slug = 'bokning-kalender';

    //      protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarScheduleLine;
    //  protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarScheduleFill;

    //  protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarTodoLine;
    //  protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarTodoFill;

    protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarScheduleLine;

    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarScheduleFill;

    //  protected static string | UnitEnum | null $navigationGroup = 'Kalendrar';
    protected static string|UnitEnum|null $navigationGroup = ' ';

    public static function shouldRegisterNavigation(): bool
    {
        //    if (Auth::user()->role === 'booking' || Auth::user()->role === 'admin' || Auth::user()->role === 'super' || Auth::user()->role === 'manager') {
        //        return true;
        //    }

        return true;

    }

    //    public static function getNavigationBadge(): ?string
    //    {
    //        $role = Str::upper(Auth::user()->role);
    //        return 'Öppen';
    //    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }
}
