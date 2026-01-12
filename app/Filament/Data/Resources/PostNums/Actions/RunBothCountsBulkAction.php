<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use App\Jobs\RunHittaCheckCountsJob;
use App\Jobs\RunRatsitCheckCountsJob;
use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class RunBothCountsBulkAction extends BulkAction
{
    public static function make(?string $name = 'runBothCounts'): static
    {
        return parent::make($name)
            ->label('H & R Counts')
            ->icon('heroicon-o-queue-list')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Run Both Hitta & Ratsit Counts')
            ->modalDescription('This will run count checks for both Hitta and Ratsit for the selected postal codes. This may take some time depending on the number of records.')
            ->modalSubmitActionLabel('Start Checks')
            ->action(function (Collection $records): void {
                // Update status for all selected records
                $records->each(function ($record) {
                    $record->update(['status' => 'running']);
                });

                // Create jobs for both hitta and ratsit counts
                $jobs = [];
                foreach ($records as $record) {
                    $jobs[] = new RunHittaCheckCountsJob($record->post_nummer);
                    $jobs[] = new RunRatsitCheckCountsJob($record->post_nummer);

                    DB::table('post_nums')
                        ->where('post_nummer', $record->post_nummer)
                        ->update(['merinfo_personer_count' => 1]);
                }

                // Get current max job ID before dispatching
                $maxJobIdBefore = DB::table('jobs')->max('id') ?? 0;

                // Create a batch with both types of jobs
                $batch = Bus::batch($jobs)
                    ->name(str_replace(' ', '', $records->first()->post_nummer).' - 🖩H&R '.now()->format('Y-m-d H:i:s'))
                    ->onQueue('default')
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
                    ->where('queue', 'default')
                    ->where('id', '>', $maxJobIdBefore)
                    ->orderBy('id')
                    ->get();

                // Update names: alternating Hitta/Ratsit for each record
                $jobIndex = 0;
                foreach ($records as $record) {

                    DB::table('post_nums')
                        ->where('post_nummer', $records->first()->post_nummer)
                        ->update(['merinfo_personer_count' => 1]);

                    // Update Hitta job name
                    if (isset($newJobs[$jobIndex])) {
                        DB::table('jobs')
                            ->where('id', $newJobs[$jobIndex]->id)
                            ->update(['name' => str_replace(' ', '', $records->first()->post_nummer).' 📟 Hitta', 'status' => 'pending', 'queue' => 'counts']);
                        $jobIndex++;
                    }

                    // Update Ratsit job name
                    if (isset($newJobs[$jobIndex])) {
                        DB::table('jobs')
                            ->where('id', $newJobs[$jobIndex]->id)
                            ->update(['name' => str_replace(' ', '', $records->first()->post_nummer).' 📟 Ratsit',  'status' => 'pending', 'queue' => 'counts']);
                        $jobIndex++;
                    }
                }

                Notification::make()
                    ->title('Both Count Checks Started')
                    ->body('Created job batch with '.($records->count() * 2)." jobs ({$records->count()} postal codes × 2 sources). Batch ID: {$batch->id}")
                    ->info()
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
