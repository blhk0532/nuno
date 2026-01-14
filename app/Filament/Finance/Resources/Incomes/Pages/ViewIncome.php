<?php

namespace App\Filament\Finance\Resources\Incomes\Pages;

use App\Filament\Finance\Resources\Incomes\IncomeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewIncome extends ViewRecord
{
    protected static string $resource = IncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
