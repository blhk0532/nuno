<?php

namespace App\Filament\App\Resources\CallingLogs\Pages;

use App\Filament\App\Resources\CallingLogs\CallingLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCallingLog extends CreateRecord
{
    protected static string $resource = CallingLogResource::class;
}
