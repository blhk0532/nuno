<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeDelaySettings\Pages;

use App\Filament\Admin\Resources\OutcomeDelaySettings\OutcomeDelaySettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditOutcomeDelaySetting extends EditRecord
{
    protected static string $resource = OutcomeDelaySettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
