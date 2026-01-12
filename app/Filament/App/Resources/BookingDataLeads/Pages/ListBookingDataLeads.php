<?php

namespace App\Filament\App\Resources\BookingDataLeads\Pages;

use App\Filament\App\Resources\BookingDataLeads\BookingDataLeadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookingDataLeads extends ListRecords
{
    protected static string $resource = BookingDataLeadResource::class;

    protected static ?string $title = 'Leads';

    protected static \UnitEnum|string|null $navigationGroup = '';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
