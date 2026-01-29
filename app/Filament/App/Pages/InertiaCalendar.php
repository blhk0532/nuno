<?php

declare(strict_types=1);

namespace App\Filament\App\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use UnitEnum;
use Filament\Support\Icons\Heroicon;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;
use Joaopaulolndev\FilamentWorldClock\Helpers\FlagsHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

final class InertiaCalendar extends Page
{
    protected string $view = 'filament.booking.pages.inertia-calendar';
  //  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;
// protected static string|BackedEnum|null $navigationIcon = 'heroicon-c-clipboard-document-check';

    protected static ?string $navigationLabel = 'Bokning';

    protected static ?string $title = '';

    protected static ?int $navigationSort = 2;

    protected static ?int $sort = 2;

    protected static ?string $slug = 'bokning-kalender';

  //      protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarScheduleLine;
  //  protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarScheduleFill;

    protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarTodoLine;
    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarTodoFill;
    //  protected static string | UnitEnum | null $navigationGroup = 'Kalendrar';
     protected static string|UnitEnum|null $navigationGroup = '';

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    public static function shouldRegisterNavigation(): bool
    {
        if(Auth::user()->role === 'booking' || Auth::user()->role === 'admin' || Auth::user()->role === 'super' || Auth::user()->role === 'manager' ){
            return true;
        }else{
            return false;
        }
    }

   public static function getNavigationBadge(): ?string
    {
        $role = Str::upper(Auth::user()->role);
        return 'Öppen';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
