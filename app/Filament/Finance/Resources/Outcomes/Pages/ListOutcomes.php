<?php

namespace App\Filament\Finance\Resources\Outcomes\Pages;

use App\Filament\Finance\Resources\Outcomes\OutcomesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOutcomes extends ListRecords
{
    protected static string $resource = OutcomesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
