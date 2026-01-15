<?php

namespace App\Filament\Product\Clusters\Products\Resources\Categories\Pages;

use App\Filament\Product\Clusters\Products\Resources\Categories\CategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
