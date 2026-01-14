<?php

namespace App\Filament\Finance\Resources\Users\Pages;

use App\Filament\Finance\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
