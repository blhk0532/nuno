<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeSettings\Pages;

use App\Filament\Admin\Resources\OutcomeSettings\OutcomeSettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditOutcomeSetting extends EditRecord
{
    protected static string $resource = OutcomeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
