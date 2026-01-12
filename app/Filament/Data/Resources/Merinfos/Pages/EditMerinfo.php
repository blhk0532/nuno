<?php

namespace App\Filament\Data\Resources\Merinfos\Pages;

use App\Filament\Data\Resources\Merinfos\MerinfoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMerinfo extends EditRecord
{
    protected static string $resource = MerinfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
