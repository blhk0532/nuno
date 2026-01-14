<?php

namespace App\Filament\User\Resources\Admins\Pages;

use App\Filament\User\Resources\Admins\AdminResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;
}
