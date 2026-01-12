<?php

namespace App\Filament\Data\Resources\RatsitPersons\Pages;

use App\Filament\Data\Resources\RatsitPersons\RatsitPersonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRatsitPerson extends CreateRecord
{
    protected static string $resource = RatsitPersonResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
