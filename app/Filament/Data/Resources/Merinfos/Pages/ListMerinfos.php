<?php

namespace App\Filament\Data\Resources\Merinfos\Pages;

use App\Filament\Data\Resources\Merinfos\MerinfoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMerinfos extends ListRecords
{
    protected static string $resource = MerinfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
