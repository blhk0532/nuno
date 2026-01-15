<?php

namespace App\Filament\Product\Clusters\Products\Resources\Products\Pages;

use App\Filament\Product\Clusters\Products\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
