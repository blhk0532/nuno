<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeDelaySettings\Pages;

use App\Filament\Admin\Resources\OutcomeDelaySettings\OutcomeDelaySettingResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateOutcomeDelaySetting extends CreateRecord
{
    protected static string $resource = OutcomeDelaySettingResource::class;
}
