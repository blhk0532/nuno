<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Brands\Pages;

use App\Filament\App\Clusters\Services\Resources\Brands\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
