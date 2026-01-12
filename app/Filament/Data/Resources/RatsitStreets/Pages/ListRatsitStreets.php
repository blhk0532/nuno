<?php

namespace App\Filament\Data\Resources\RatsitStreets\Pages;

use App\Filament\Data\Resources\RatsitStreets\RatsitStreetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRatsitStreets extends ListRecords
{
    protected static string $resource = RatsitStreetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
