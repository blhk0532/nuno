<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use App\Jobs\RunHittaPostOrtDirectJob;
use Exception;
use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

class RunHittaPortOrtDirectBulkAction extends BulkAction
{
    public static function make(?string $name = 'runHittaPortOrtDirect'): static
    {
        return parent::make($name)
            ->label('Hitta PostOrt (Direct)')
            ->icon('heroicon-o-bolt')
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading('Bulk Direct Hitta Post Ort Search')
            ->modalDescription('This will run direct jobs for all selected post numbers. Each job processes all pages sequentially without batching and forces database saves. This is more reliable but slower than batched mode.')
            ->modalSubmitActionLabel('Run Direct Jobs')
            ->action(function (Collection $records): void {
                $dispatchedCount = 0;

                // Dispatch direct jobs for each record
                $records->each(function ($record) use (&$dispatchedCount) {
                    try {
                        // Update status immediately
                        $record->update(['status' => 'running', 'hitta_personer_queue' => true]);

                        // Dispatch direct job
                        RunHittaPostOrtDirectJob::dispatch($record->id);

                        $dispatchedCount++;
                    } catch (Exception $e) {
                        Notification::make()
                            ->title('Error Dispatching Job')
                            ->body("Failed to dispatch job for {$record->post_nummer}: {$e->getMessage()}")
                            ->danger()
                            ->send();
                    }
                });

                Notification::make()
                    ->title('Direct Hitta PostOrt Jobs Started')
                    ->body("Successfully dispatched {$dispatchedCount} direct job(s). Each job will process all pages sequentially and force-save data to database.")
                    ->warning()
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
