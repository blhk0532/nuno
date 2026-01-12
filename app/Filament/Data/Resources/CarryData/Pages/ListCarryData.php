<?php

namespace App\Filament\Data\Resources\CarryData\Pages;

use App\Filament\Data\Resources\CarryData\CarryDataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCarryData extends ListRecords
{
    protected static string $resource = CarryDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
