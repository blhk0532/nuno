<?php

namespace App\Filament\Data\Resources\HittaSes\Pages;

use App\Filament\Data\Resources\HittaSes\HittaSeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHittaSe extends EditRecord
{
    protected static string $resource = HittaSeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
