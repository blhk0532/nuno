<?php

namespace App\Filament\App\Resources\CallingLogs\Pages;

use App\Filament\App\Resources\CallingLogs\CallingLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCallingLog extends EditRecord
{
    protected static string $resource = CallingLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
