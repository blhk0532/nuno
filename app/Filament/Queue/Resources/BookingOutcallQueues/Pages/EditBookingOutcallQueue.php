<?php

namespace App\Filament\Queue\Resources\BookingOutcallQueues\Pages;

use App\Filament\Queue\Resources\BookingOutcallQueues\BookingOutcallQueueResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBookingOutcallQueue extends EditRecord
{
    protected static string $resource = BookingOutcallQueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
