<?php

namespace App\Filament\App\Resources\RingaData\Pages;

use App\Filament\App\Resources\RingaData\RingaDataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRingaData extends ListRecords
{
    protected static string $resource = RingaDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
