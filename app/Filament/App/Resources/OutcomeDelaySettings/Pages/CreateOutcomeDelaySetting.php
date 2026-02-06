<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\OutcomeDelaySettings\Pages;

use App\Filament\App\Resources\OutcomeDelaySettings\OutcomeDelaySettingResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateOutcomeDelaySetting extends CreateRecord
{
    protected static string $resource = OutcomeDelaySettingResource::class;
}
