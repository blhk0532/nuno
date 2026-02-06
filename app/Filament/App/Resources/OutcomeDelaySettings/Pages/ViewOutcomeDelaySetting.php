<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\OutcomeDelaySettings\Pages;

use App\Filament\App\Resources\OutcomeDelaySettings\OutcomeDelaySettingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewOutcomeDelaySetting extends ViewRecord
{
    protected static string $resource = OutcomeDelaySettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
