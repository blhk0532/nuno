<?php

declare(strict_types=1);

namespace Adultdate\FilamentUser\Resources\UserTypeResource\Pages;

use Adultdate\FilamentUser\Resources\UserTypeResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateUserType extends CreateRecord
{
    protected static string $resource = UserTypeResource::class;
}
