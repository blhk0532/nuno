<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Categories\Pages;

use App\Filament\App\Clusters\Services\Resources\Categories\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
