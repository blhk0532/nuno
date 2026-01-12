<?php

namespace App\Filament\Data\Resources\RatsitStreets\Pages;

use App\Filament\Data\Resources\RatsitStreets\RatsitStreetResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRatsitStreet extends ViewRecord
{
    protected static string $resource = RatsitStreetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
