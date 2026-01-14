<?php

namespace App\Filament\Dialer\Resources\BookingDataLeads\Pages;

use App\Filament\Dialer\Resources\BookingDataLeads\BookingDataLeadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookingDataLeads extends ListRecords
{
    protected static string $resource = BookingDataLeadResource::class;

    protected static ?string $title = 'Leads';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
