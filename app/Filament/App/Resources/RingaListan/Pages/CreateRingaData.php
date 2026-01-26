<?php

namespace App\Filament\App\Resources\RingaListan\Pages;

use App\Filament\App\Resources\RingaListan\RingaListanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRingaData extends CreateRecord
{
    protected static string $resource = RingaListanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['team_id'] = filament()->getTenant()?->id;

        return $data;
    }
}
