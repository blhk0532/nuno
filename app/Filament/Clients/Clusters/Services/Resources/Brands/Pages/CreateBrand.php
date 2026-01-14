<?php

namespace App\Filament\Clients\Clusters\Services\Resources\Brands\Pages;

use App\Filament\Clients\Clusters\Services\Resources\Brands\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBrand extends CreateRecord
{
    protected static string $resource = BrandResource::class;
}
