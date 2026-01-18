<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Services\Pages;

use App\Filament\App\Clusters\Services\Resources\Services\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
