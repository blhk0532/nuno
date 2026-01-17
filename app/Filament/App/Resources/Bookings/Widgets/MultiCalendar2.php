<?php

namespace App\Filament\App\Resources\Bookings\Widgets;

use Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar2 as BaseMultiCalendar2;

class MultiCalendar2 extends BaseMultiCalendar2
{
    public function getHeading(): string
    {
        $calendarName = $this->selectedTechnician ? \App\Models\BookingCalendar::find($this->selectedTechnician)?->name : 'All Tekniker';
        return '#2 ◴ ' . $calendarName;
    }
}