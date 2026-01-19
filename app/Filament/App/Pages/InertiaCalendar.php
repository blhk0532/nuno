<?php

declare(strict_types=1);

namespace App\Filament\App\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use UnitEnum;

final class InertiaCalendar extends Page
{
    protected string $view = 'filament.booking.pages.inertia-calendar';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-c-calendar-days';

    protected static ?string $navigationLabel = 'NDS Bokning';

    protected static ?string $title = '';

    protected static ?int $navigationSort = 2;

    protected static ?int $sort = 2;

    protected static ?string $slug = 'inertia-calendar';

    //  protected static string | UnitEnum | null $navigationGroup = 'Kalendrar';
    protected static string|UnitEnum|null $navigationGroup = '';

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }



   public static function getNavigationBadge(): ?string
    {
        return now()->timezone('Europe/Stockholm')->format('H:i');
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
