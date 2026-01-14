<?php

namespace App\Filament\Sheets\Resources\BookingOutcallQueues\Pages;

use App\Filament\Sheets\Resources\BookingOutcallQueues\BookingOutcallQueueResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookingOutcallQueue extends CreateRecord
{
    protected static string $resource = BookingOutcallQueueResource::class;
}
