<?php

namespace App\Filament\App\Resources\RingaData\Pages;

use App\Filament\App\Resources\RingaData\RingaDataResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRingaData extends ViewRecord
{
    protected static string $resource = RingaDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
