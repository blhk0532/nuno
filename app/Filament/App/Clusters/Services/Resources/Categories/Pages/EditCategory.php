<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Categories\Pages;

use App\Filament\App\Clusters\Services\Resources\Categories\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
