<?php

namespace App\Filament\Data\Resources\RatsitPersons\Pages;

use App\Filament\Data\Resources\RatsitPersons\RatsitPersonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRatsitPersons extends ListRecords
{
    protected static string $resource = RatsitPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
