<?php

namespace App\Filament\Product\Clusters\Products\Resources\Brands\Pages;

use App\Filament\Product\Clusters\Products\Resources\Brands\BrandResource;
use Adultdate\FilamentBooking\Filament\Exports\Booking\BrandExporter;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getActions(): array
    {
        return [
            ExportAction::make()
                ->exporter(BrandExporter::class),
            CreateAction::make(),
        ];
    }
}
