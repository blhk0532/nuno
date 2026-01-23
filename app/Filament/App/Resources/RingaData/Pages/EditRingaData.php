<?php

namespace App\Filament\App\Resources\RingaData\Pages;

use App\Filament\App\Resources\RingaData\RingaDataResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRingaData extends EditRecord
{
    protected static string $resource = RingaDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
