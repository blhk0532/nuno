<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use App\Jobs\RunRatsitCheckCountsJob;
use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class RunRatsitCountsBulkAction extends BulkAction
{
    public static function make(?string $name = 'runRatsitCounts'): static
    {
        return parent::make($name)
            ->label('Ratsit Counts')
            ->icon('heroicon-o-calculator')
            ->requiresConfirmation()
            ->modalHeading('Bulk Queue Ratsit.se Count Checks')
            ->modalDescription('This will create a job batch to run ratsit_check_counts.mjs script for all selected post numbers to get Personer and Företag counts from Ratsit.se and update the database.')
            ->modalSubmitActionLabel('Queue Batch')
            ->action(function (Collection $records): void {
                // Update status for all selected records
                $records->each(function ($record) {
                    $record->update(['status' => 'running']);
                });

                // Create jobs for each record
                $jobs = $records->map(function ($record) {
                    return new RunRatsitCheckCountsJob($record->post_nummer);
                })->toArray();

                // Create job batch
                $batch = Bus::batch($jobs)
                    ->name('Bulk Ratsit Counts - '.now()->format('Y-m-d H:i:s'))
                    ->onQueue('counts')
                    ->then(function ($batch) {
                        // Update batch status to complete when all jobs finish
                        DB::table('job_batches')
                            ->where('id', $batch->id)
                            ->update(['status' => 'complete']);
                    })
                    ->dispatch();

                // Set batch status to pending
                DB::table('job_batches')
                    ->where('id', $batch->id)
                    ->update(['status' => 'pending']);

                // Update job names in database after dispatching
                foreach ($records as $record) {
                    DB::table('jobs')
                        ->where('queue', 'counts')
                        ->whereNull('name')
                        ->orderBy('id', 'desc')
                        ->limit(1)
                        ->update(['name' => $record->post_nummer.' - Ratsit Counts']);
                }

                Notification::make()
                    ->title('Bulk Ratsit.se Counts Started')
                    ->body("Created job batch with {$records->count()} Ratsit.se count checks. Batch ID: {$batch->id}. The jobs will run in the background. Refresh the page after a few minutes to see the updated counts.")
                    ->info()
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
