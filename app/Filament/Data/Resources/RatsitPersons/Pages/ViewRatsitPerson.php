<?php

namespace App\Filament\Data\Resources\RatsitPersons\Pages;

use App\Filament\Data\Resources\RatsitPersons\RatsitPersonResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRatsitPerson extends ViewRecord
{
    protected static string $resource = RatsitPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
