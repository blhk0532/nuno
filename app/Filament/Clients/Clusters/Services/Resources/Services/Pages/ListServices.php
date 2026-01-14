<?php

namespace App\Filament\Clients\Clusters\Services\Resources\Services\Pages;

use App\Filament\Clients\Clusters\Services\Resources\Services\ServiceResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListServices extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return ServiceResource::getWidgets();
    }
}
