<?php

namespace App\Filament\Clients\Clusters\Services\Resources\Categories\Pages;

use App\Filament\Clients\Clusters\Services\Resources\Categories\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
