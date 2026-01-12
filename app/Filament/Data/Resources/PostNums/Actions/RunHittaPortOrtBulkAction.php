<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use App\Jobs\RunHittaPostOrtSplitJob;
use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class RunHittaPortOrtBulkAction extends BulkAction
{
    public static function make(?string $name = 'runHittaPortOrt'): static
    {
        return parent::make($name)
            ->label('Hitta PostOrt')
            ->icon('heroicon-o-users')
            ->color('info')
            ->requiresConfirmation()
            ->modalHeading('Bulk Queue Hitta Post Ort Search')
            ->modalDescription('This will create a job batch to run script for all selected post numbers. Each search will scrape person data from Hitta.se and may take several minutes per post number.')
            ->modalSubmitActionLabel('Queue Batch')
            ->action(function (Collection $records): void {
                // Update status for all selected records
                $records->each(function ($record) {
                    $record->update(['status' => 'running', 'hitta_personer_queue' => true]);
                });

                // Create SPLIT jobs for each record (each split job will create per-page jobs)
                $jobs = $records->map(function ($record) {
                    return new RunHittaPostOrtSplitJob($record->id);
                })->toArray();

                // Get current max job ID before dispatching
                $maxJobIdBefore = DB::table('jobs')->max('id') ?? 0;

                // Create job batch
                $batch = Bus::batch($jobs)
                    ->name('Bulk Hitta PostOrt (split) - '.now()->format('Y-m-d H:i:s'))
                    ->onQueue('hitta-postort')
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
                // Update job names for split jobs
                $newJobs = DB::table('jobs')
                    ->where('queue', 'hitta-postort')
                    ->where('id', '>', $maxJobIdBefore)
                    ->orderBy('id')
                    ->get();

                foreach ($records as $index => $record) {
                    if (isset($newJobs[$index])) {
                        DB::table('jobs')
                            ->where('id', $newJobs[$index]->id)
                            ->update(['name' => str_replace(' ', '', $record->post_nummer).' 📄 Split', 'status' => 'pending']);
                    }
                }

                Notification::make()
                    ->title('Bulk Hitta PostOrt (Split) Started')
                    ->body("Created split job batch for {$records->count()} post ort(s). Batch ID: {$batch->id}. Each split job will create one page job per results page (25 results per job).")
                    ->info()
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
