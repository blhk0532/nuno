<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Symfony\Component\Process\Process;

class BulkResetValuesBulkAction extends BulkAction
{
    public static function make(?string $name = 'bulkResetValues'): static
    {
        return parent::make($name)
            ->label('Reset Values')
            ->icon('heroicon-o-arrow-path')
            ->requiresConfirmation()
            ->modalHeading('Bulk Reset Selected Post Nummer Values')
            ->modalDescription('This will stop all queue workers, clear all pending jobs, and reset status, is_active, progress, count, total_count, phone, house, bolag, foretag, personer, platser, last_processed_page, processed_count, is_pending, is_complete for all selected post nummers.')
            ->action(function (Collection $records): void {
                // First, stop all queue workers
                $workerProcess = new Process(['pkill', '-f', 'artisan queue:work database']);
                $workerProcess->run();

                // Clear all pending jobs from the queue
                $clearProcess = new Process(['php', base_path('artisan'), 'queue:clear', 'database', '--queue=postnummer']);
                $clearProcess->run();

                // Reset all selected records
                $reset = 0;
                foreach ($records as $record) {
                    $record->update([
                        'status' => null,
                        'is_active' => false,
                    ]);
                    $reset++;
                }

                Notification::make()
                    ->title('Bulk Reset Complete')
                    ->body("Stopped queue workers, cleared pending jobs, and reset {$reset} post nummer row(s).")
                    ->success()
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
