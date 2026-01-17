<?php

namespace App\Filament\App\Resources\Bookings\Widgets;

use Adultdate\FilamentBooking\Filament\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar3 as BaseMultiCalendar3;

class MultiCalendar3 extends BaseMultiCalendar3
{
    public function getHeading(): string
    {
        $calendarName = $this->selectedTechnician ? \App\Models\BookingCalendar::find($this->selectedTechnician)?->name : 'All Tekniker';
        return '#3 ◴ ' . $calendarName;
    }
}