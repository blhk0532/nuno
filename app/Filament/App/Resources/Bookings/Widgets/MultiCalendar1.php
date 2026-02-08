<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\Bookings\Widgets;

use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\MultiCalendar1 as BaseMultiCalendar1;

final class MultiCalendar1 extends BaseMultiCalendar1
{
    public function getHeading(): string
    {
        $calendarName = $this->selectedTechnician ? \App\Models\BookingCalendar::find($this->selectedTechnician)?->name : 'All Tekniker';

        return '#1 ◴ '.$calendarName;
    }
}
