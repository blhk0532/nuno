<?php

namespace App\Filament\Super\Resources\PanelAccesses\Pages;

use App\Filament\Super\Resources\PanelAccesses\PanelAccessResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPanelAccess extends EditRecord
{
    protected static string $resource = PanelAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
