<?php

namespace App\Listeners;

use Illuminate\Queue\Events\JobQueued;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateQueuedJobName
{
    /**
     * Handle the event.
     */
    public function handle(JobQueued $event): void
    {
        try {
            // Get the display name from the payload
            $displayName = $event->payload()['displayName'] ?? null;

            if ($displayName && $event->id) {
                // Update the jobs table with the display name
                DB::table('jobs')
                    ->where('id', $event->id)
                    ->update(['name' => $displayName]);
            }
        } catch (Throwable $e) {
            // Silently fail - this is not critical
            Log::debug('Failed to update job name', [
                'error' => $e->getMessage(),
                'job_id' => $event->id ?? null,
            ]);
        }
    }
}
