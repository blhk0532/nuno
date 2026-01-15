<?php

namespace App\Filament\Queue\Resources\BookingDataLeads\Pages;

use App\Filament\Queue\Resources\BookingDataLeads\BookingDataLeadResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBookingDataLead extends EditRecord
{
    protected static string $resource = BookingDataLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
