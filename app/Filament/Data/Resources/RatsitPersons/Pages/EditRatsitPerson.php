<?php

namespace App\Filament\Data\Resources\RatsitPersons\Pages;

use App\Filament\Data\Resources\RatsitPersons\RatsitPersonResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRatsitPerson extends EditRecord
{
    protected static string $resource = RatsitPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
