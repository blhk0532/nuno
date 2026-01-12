<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use App\Jobs\RunRatsitSearchPersonsJob;
use App\Models\RatsitData;
use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class RunRatsitPersonerBulkAction extends BulkAction
{
    public static function make(?string $name = 'runRatsitPersoner'): static
    {
        return parent::make($name)
            ->label('Ratsit Personer')
            ->icon('heroicon-o-users')
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading('Bulk Queue Ratsit Personer Search')
            ->modalDescription('This will create a job batch to run ratsitSearchPersonsQueue.mjs script for all selected post numbers. Each search will scrape person data from Ratsit.se and may take several minutes per post number.')
            ->modalSubmitActionLabel('Queue Batch')
            ->action(function (Collection $records): void {
                // Update status for all selected records
                $records->each(function ($record) {
                    $record->update(['status' => 'running', 'ratsit_personer_queue' => true]);

                    // Queue all RatsitData records for this postnummer
                    RatsitData::where('postnummer', $record->post_nummer)
                        ->update(['is_queued' => true]);
                });

                // Create jobs for each record
                $jobs = $records->map(function ($record) {
                    return new RunRatsitSearchPersonsJob($record->id);
                })->toArray();

                // Get current max job ID before dispatching
                $maxJobIdBefore = DB::table('jobs')->max('id') ?? 0;

                // Create job batch
                $batch = Bus::batch($jobs)
                    ->name('Bulk Ratsit Personer - '.now()->format('Y-m-d H:i:s'))
                    ->onQueue('ratsit-personer')
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
                    ->where('queue', 'ratsit-personer')
                    ->where('id', '>', $maxJobIdBefore)
                    ->orderBy('id')
                    ->get();

                foreach ($records as $index => $record) {
                    if (isset($newJobs[$index])) {
                        DB::table('jobs')
                            ->where('id', $newJobs[$index]->id)
                            ->update(['name' => '👤 Ratsit: '.$record->post_nummer, 'status' => 'pending']);
                    }
                }

                Notification::make()
                    ->title('Bulk Ratsit Personer Started')
                    ->body("Created job batch with {$records->count()} Ratsit personer searches. Batch ID: {$batch->id}")
                    ->warning()
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
