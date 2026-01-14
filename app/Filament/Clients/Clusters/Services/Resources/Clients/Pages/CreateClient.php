<?php

namespace App\Filament\Clients\Clusters\Services\Resources\Clients\Pages;

use App\Filament\Clients\Clusters\Services\Resources\Clients\ClientResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['ulid'] = (string) Str::ulid();

        return $data;
    }
}
