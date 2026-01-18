<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Clients\Pages;

use App\Filament\App\Clusters\Services\Resources\Clients\ClientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
