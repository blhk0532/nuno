<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use App\Filament\Actions\PostNummerChecks\CheckDbCountsAction;
use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

class CheckDbCountsBulkAction extends BulkAction
{
    public static function make(?string $name = 'checkDbCounts'): static
    {
        return parent::make($name)
            ->label('Check Counts')
            ->icon('heroicon-o-calculator')
            ->color('info')
            ->requiresConfirmation()
            ->modalHeading('Database Count Check')
            ->modalDescription('This will count records in hitta_data, ratsit_data, and merinfo_data tables for each selected post number and update the respective count columns.')
            ->modalSubmitActionLabel('Check Counts')
            ->action(function (Collection $records): void {
                $count = 0;
                foreach ($records as $record) {
                    CheckDbCountsAction::execute($record);
                    $count++;
                }

                Notification::make()
                    ->success()
                    ->title('Database Counts Updated')
                    ->body("Successfully checked and updated database counts for {$count} post nummer(s).")
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
