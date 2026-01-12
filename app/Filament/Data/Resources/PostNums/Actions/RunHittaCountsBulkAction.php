<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use App\Jobs\RunHittaCheckCountsJob;
use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class RunHittaCountsBulkAction extends BulkAction
{
    public static function make(?string $name = 'runHittaCounts'): static
    {
        return parent::make($name)
            ->label('Hitta Counts')
            ->icon('heroicon-o-calculator')
            ->requiresConfirmation()
            ->modalHeading('Bulk Queue Hitta.se Count Checks')
            ->modalDescription('This will create a job batch to run hitta_check_counts.mjs script for all selected post numbers to get Personer and Företag counts from Hitta.se and update the database.')
            ->modalSubmitActionLabel('Queue Batch')
            ->action(function (Collection $records): void {
                // Update status for all selected records
                $records->each(function ($record) {
                    $record->update(['status' => 'running']);
                });

                // Create jobs for each record
                $jobs = $records->map(function ($record) {
                    return new RunHittaCheckCountsJob($record->post_nummer);
                })->toArray();

                // Get current max job ID before dispatching
                $maxJobIdBefore = DB::table('jobs')->max('id') ?? 0;

                // Create job batch
                $batch = Bus::batch($jobs)
                    ->name('Bulk Hitta Counts - '.now()->format('Y-m-d H:i:s'))
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

                // Update job names for newly created jobs
                $newJobs = DB::table('jobs')
                    ->where('queue', 'counts')
                    ->where('id', '>', $maxJobIdBefore)
                    ->orderBy('id')
                    ->get();

                foreach ($records as $index => $record) {
                    if (isset($newJobs[$index])) {
                        DB::table('jobs')
                            ->where('id', $newJobs[$index]->id)
                            ->update(['name' => 'Postnummer: '.$record->post_nummer]);
                    }
                }

                Notification::make()
                    ->title('Bulk Hitta.se Counts Started')
                    ->body("Created job batch with {$records->count()} Hitta.se count checks. Batch ID: {$batch->id}")
                    ->info()
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
