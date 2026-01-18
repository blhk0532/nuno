<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Clients\Pages;

use App\Filament\App\Clusters\Services\Resources\Clients\ClientResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

final class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['ulid'] = (string) Str::ulid();

        return $data;
    }
}
