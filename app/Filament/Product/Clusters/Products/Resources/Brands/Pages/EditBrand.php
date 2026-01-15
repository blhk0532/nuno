<?php

namespace App\Filament\Product\Clusters\Products\Resources\Brands\Pages;

use App\Filament\Product\Clusters\Products\Resources\Brands\BrandResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
