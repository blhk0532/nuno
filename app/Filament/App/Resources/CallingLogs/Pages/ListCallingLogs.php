<?php

namespace App\Filament\App\Resources\CallingLogs\Pages;

use App\Filament\App\Resources\CallingLogs\CallingLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCallingLogs extends ListRecords
{
    protected static string $resource = CallingLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
