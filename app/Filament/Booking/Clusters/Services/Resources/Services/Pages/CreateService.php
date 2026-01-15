<?php

namespace App\Filament\Booking\Clusters\Services\Resources\Services\Pages;

use App\Filament\Booking\Clusters\Services\Resources\Services\ServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;
}
