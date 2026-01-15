<?php

namespace App\Filament\Queue\Resources\BookingOutcallQueues\Pages;

use App\Filament\Queue\Resources\BookingOutcallQueues\BookingOutcallQueueResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookingOutcallQueue extends CreateRecord
{
    protected static string $resource = BookingOutcallQueueResource::class;
}
