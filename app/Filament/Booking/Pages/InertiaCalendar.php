<?php

namespace App\Filament\Booking\Pages;

use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Enums\Width;
use UnitEnum;


class InertiaCalendar extends Page
{
    protected string $view = 'filament.booking.pages.inertia-calendar';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'NDS Kalendrar';

    protected static ?string $title = '';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'inertia-calendar';

         protected static string | UnitEnum | null $navigationGroup = 'Boknings Kalendrar';


public function getMaxContentWidth(): Width
{
    return Width::Full;
}


}
