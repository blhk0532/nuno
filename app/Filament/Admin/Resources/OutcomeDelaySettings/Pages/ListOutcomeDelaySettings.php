<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeDelaySettings\Pages;

use App\Filament\Admin\Resources\OutcomeDelaySettings\OutcomeDelaySettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListOutcomeDelaySettings extends ListRecords
{
    protected static string $resource = OutcomeDelaySettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
