<?php

declare(strict_types=1);

namespace App\Filament\Data\Resources\JobBatches\Pages;

use App\Filament\Data\Resources\JobBatches\JobBatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListJobBatches extends ListRecords
{
    protected static string $resource = JobBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
