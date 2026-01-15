<?php

namespace App\Filament\Queue\Resources\BookingOutcallQueues\Pages;

use App\Filament\Queue\Resources\BookingOutcallQueues\BookingOutcallQueueResource;
use App\Filament\Queue\Resources\BookingOutcallQueues\Widgets\BookingOutcallQueueActions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBookingOutcallQueue extends ViewRecord
{
    protected static string $resource = BookingOutcallQueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BookingOutcallQueueActions::make(),
        ];
    }
}
