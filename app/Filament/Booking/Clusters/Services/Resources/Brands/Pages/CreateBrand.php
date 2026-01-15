<?php

namespace App\Filament\Booking\Clusters\Services\Resources\Brands\Pages;

use App\Filament\Booking\Clusters\Services\Resources\Brands\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBrand extends CreateRecord
{
    protected static string $resource = BrandResource::class;
}
