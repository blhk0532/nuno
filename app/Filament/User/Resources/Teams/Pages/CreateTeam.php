<?php

namespace App\Filament\User\Resources\Teams\Pages;

use App\Filament\User\Resources\Teams\TeamResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;
}
