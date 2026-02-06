<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeSettings\Pages;

use App\Filament\Admin\Resources\OutcomeSettings\OutcomeSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListOutcomeSettings extends ListRecords
{
    protected static string $resource = OutcomeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
