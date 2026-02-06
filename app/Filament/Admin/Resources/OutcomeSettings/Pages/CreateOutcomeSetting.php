<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeSettings\Pages;

use App\Filament\Admin\Resources\OutcomeSettings\OutcomeSettingResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateOutcomeSetting extends CreateRecord
{
    protected static string $resource = OutcomeSettingResource::class;
}
