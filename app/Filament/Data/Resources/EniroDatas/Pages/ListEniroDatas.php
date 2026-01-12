<?php

namespace App\Filament\Data\Resources\EniroDatas\Pages;

use App\Filament\Data\Resources\EniroDatas\EniroDatasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEniroDatas extends ListRecords
{
    protected static string $resource = EniroDatasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
