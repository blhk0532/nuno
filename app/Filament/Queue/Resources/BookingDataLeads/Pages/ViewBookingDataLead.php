<?php

namespace App\Filament\Queue\Resources\BookingDataLeads\Pages;

use App\Filament\Queue\Resources\BookingDataLeads\BookingDataLeadResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBookingDataLead extends ViewRecord
{
    protected static string $resource = BookingDataLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
