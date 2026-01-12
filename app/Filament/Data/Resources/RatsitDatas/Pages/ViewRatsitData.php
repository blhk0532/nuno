<?php

namespace App\Filament\Data\Resources\RatsitDatas\Pages;

use App\Filament\Data\Resources\RatsitDatas\RatsitDataResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRatsitData extends ViewRecord
{
    protected static string $resource = RatsitDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
