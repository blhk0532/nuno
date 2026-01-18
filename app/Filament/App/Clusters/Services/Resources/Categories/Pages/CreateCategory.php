<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Categories\Pages;

use App\Filament\App\Clusters\Services\Resources\Categories\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
