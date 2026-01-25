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
final class InertiaCalendar extends Page
{
    protected string $view = 'filament.booking.pages.inertia-calendar';
  //  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;
// protected static string|BackedEnum|null $navigationIcon = 'heroicon-c-clipboard-document-check';

    protected static ?string $navigationLabel = 'Bokning';

    protected static ?string $title = '';

    protected static ?int $navigationSort = 4;

    protected static ?int $sort = 4;

    protected static ?string $slug = 'bokning';

  //      protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarScheduleLine;
  //  protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarScheduleFill;
    protected static string|BackedEnum|null $navigationIcon = Remix::RiCalendarCheckLine;
    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiCalendarCheckFill;

    //  protected static string | UnitEnum | null $navigationGroup = 'Kalendrar';
     protected static string|UnitEnum|null $navigationGroup = '';

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }



   public static function getNavigationBadge(): ?string
    {
        return 'Öppen';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
