<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\OutcomeDelaySettings\Pages;

use App\Filament\App\Resources\OutcomeDelaySettings\OutcomeDelaySettingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

final class EditOutcomeDelaySetting extends EditRecord
{
    protected static string $resource = OutcomeDelaySettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
