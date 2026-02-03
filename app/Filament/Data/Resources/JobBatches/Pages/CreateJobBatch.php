<?php

declare(strict_types=1);

namespace App\Filament\Data\Resources\JobBatches\Pages;

use App\Filament\Data\Resources\JobBatches\JobBatchResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateJobBatch extends CreateRecord
{
    protected static string $resource = JobBatchResource::class;
}
