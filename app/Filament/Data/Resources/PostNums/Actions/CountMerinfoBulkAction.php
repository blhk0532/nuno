<?php

namespace App\Filament\Data\Resources\PostNums\Actions;

use App\Jobs\RunMerinfoScript;
use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Log;

class CountMerinfoBulkAction extends BulkAction
{
    public static function make(?string $name = 'countMerinfo'): static
    {
        return parent::make($name)
            ->label('Count Merinfo')
            ->icon('heroicon-o-calculator')
            ->color('primary')
            ->requiresConfirmation()
            ->modalHeading('Queue Merinfo Count')
            ->modalDescription('Create Merinfo count batches (one per postnummer) on the merinfo-count queue for all selected rows. Existing active batches with the same postnummer will be skipped.')
            ->modalSubmitActionLabel('Queue Count')
            ->action(function (Collection $records): void {
                Log::info('Count Merinfo bulk action triggered', ['record_count' => $records->count()]);
                $queued = 0;
                $skipped = 0;
                foreach ($records as $record) {
                    $raw = $record->post_nummer;
                    $normalized = preg_replace('/\s+/', '', $raw);
                    if (! preg_match('/^[0-9]{5}$/', $normalized)) {
                        $skipped++;

                        continue; // skip invalid formats
                    }
                    // Check existing batch by name
                    $existing = \DB::table('job_batches')->where('name', $normalized)->first();
                    if ($existing && ! $existing->finished_at && ! $existing->cancelled_at && (int) $existing->pending_jobs > 0) {
                        $skipped++;

                        continue; // active batch exists
                    }

                    // Get max job ID before dispatching
                    $maxJobIdBefore = \DB::table('jobs')->max('id') ?? 0;

                    Log::info('About to dispatch merinfo-count batch', ['postnummer' => $normalized, 'max_job_id_before' => $maxJobIdBefore]);

                    $batch = Bus::batch([
                        new RunMerinfoScript($normalized, 'merinfo-count'),
                    ])->name($normalized)
                        ->onQueue('merinfo-count')
                        ->then(function ($batch) {
                            // Update batch status to complete when all jobs finish
                            \DB::table('job_batches')
                                ->where('id', $batch->id)
                                ->update(['status' => 'complete']);
                        })
                        ->dispatch();

                    // Set batch status to pending
                    \DB::table('job_batches')
                        ->where('id', $batch->id)
                        ->update(['status' => 'pending']);

                    // Update the newly created job's status to "pending"
                    \DB::table('jobs')
                        ->where('id', '>', $maxJobIdBefore)
                        ->where('payload', 'like', '%RunMerinfoScript%')
                        ->where('payload', 'like', '%merinfo-count%')
                        ->update([
                            'name' => $normalized,
                            'status' => 'pending',
                        ]);

                    // Update record status
                    $record->update([
                        'status' => 'queued_merinfo_count',
                        'is_active' => true,
                    ]);

                    $queued++;
                }
                Notification::make()
                    ->title('Merinfo Count Queue')
                    ->body("Queued {$queued} count batch(es). Skipped {$skipped} (invalid or already active). Start a merinfo-count queue worker to process.")
                    ->success()
                    ->send();
            })
            ->deselectRecordsAfterCompletion()
            ->closeModalByClickingAway(false);
    }
}
