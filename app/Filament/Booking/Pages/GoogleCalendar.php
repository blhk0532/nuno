<?php

namespace App\Filament\Booking\Pages;

use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Enums\Width;
use UnitEnum;
class GoogleCalendar extends Page
{
    protected string $view = 'filament.booking.pages.google-calendar';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Google Calendar';

    protected static ?string $title = '';

    protected static ?int $navigationSort = 10;

    protected static ?string $slug = 'google-calendar';

         protected static string | UnitEnum | null $navigationGroup = 'Boknings Kalendrar';



public function getMaxContentWidth(): Width
{
    return Width::Full;
}


}
