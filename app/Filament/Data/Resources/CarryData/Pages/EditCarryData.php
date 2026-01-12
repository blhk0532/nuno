<?php

namespace App\Filament\Data\Resources\CarryData\Pages;

use App\Filament\Data\Resources\CarryData\CarryDataResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCarryData extends EditRecord
{
    protected static string $resource = CarryDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
