<?php

namespace App\Filament\App\Resources\RingaData\Pages;

use App\Filament\App\Resources\RingaData\RingaDataResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRingaData extends CreateRecord
{
    protected static string $resource = RingaDataResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['team_id'] = filament()->getTenant()?->id;

        return $data;
    }
}
