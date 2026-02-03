<?php

declare(strict_types=1);

namespace App\Filament\Data\Resources\JobBatches\Pages;

use App\Filament\Data\Resources\JobBatches\JobBatchResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditJobBatch extends EditRecord
{
    protected static string $resource = JobBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
