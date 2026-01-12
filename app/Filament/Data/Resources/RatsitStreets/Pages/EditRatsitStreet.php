<?php

namespace App\Filament\Data\Resources\RatsitStreets\Pages;

use App\Filament\Data\Resources\RatsitStreets\RatsitStreetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRatsitStreet extends EditRecord
{
    protected static string $resource = RatsitStreetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
