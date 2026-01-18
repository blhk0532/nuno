<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Brands\Pages;

use App\Filament\App\Clusters\Services\Resources\Brands\BrandResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateBrand extends CreateRecord
{
    protected static string $resource = BrandResource::class;
}
