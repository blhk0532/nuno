<?php

namespace App\Filament\Super\Resources\PanelAccesses\Pages;

use App\Filament\Super\Resources\PanelAccesses\PanelAccessResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPanelAccesses extends ListRecords
{
    protected static string $resource = PanelAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
