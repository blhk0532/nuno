<?php

declare(strict_types=1);

namespace App\Filament\Data\Resources\Jobs\Pages;

use App\Filament\Data\Resources\Jobs\JobResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;
}
