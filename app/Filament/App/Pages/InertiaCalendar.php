<?php

declare(strict_types=1);

namespace App\Filament\App\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use UnitEnum;
use Filament\Support\Icons\Heroicon;
use Joaopaulolndev\FilamentWorldClock\Helpers\FlagsHelper;
final class InertiaCalendar extends Page
{
    protected string $view = 'filament.booking.pages.inertia-calendar';
  //  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;
  protected static string|BackedEnum|null $navigationIcon = 'heroicon-c-clipboard-document-check';

    protected static ?string $navigationLabel = 'NDS Bokningen';

    protected static ?string $title = '';

    protected static ?int $navigationSort = 6;

    protected static ?int $sort = 6;

    protected static ?string $slug = 'inertia-calendar';

    //  protected static string | UnitEnum | null $navigationGroup = 'Kalendrar';
    // protected static string|UnitEnum|null $navigationGroup = '';

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }



   public static function getNavigationBadge(): ?string
    {
        return '🇸🇪 ' . now()->timezone('Europe/Stockholm')->format('H:i');
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }
}
