<?php

namespace App\Filament\Booking\Clusters\Services\Resources\Services\Pages;

use App\Filament\Booking\Clusters\Services\Resources\Services\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
