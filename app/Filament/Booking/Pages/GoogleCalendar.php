<?php

namespace App\Filament\Booking\Pages;

use Filament\Pages\Page;
use BackedEnum;

class GoogleCalendar extends Page
{
    protected string $view = 'filament.booking.pages.google-calendar';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Google Kalender';

    protected static ?string $title = '';

    protected static ?string $slug = 'google-calendar';
}
