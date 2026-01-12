<?php

namespace App\Jobs;

use App\Models\PostNum;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class RunHittaSearchPersonsOptimizedJob implements ShouldQueue
{
    use Batchable;
    use Queueable;

    protected $postNumId;

    protected $includeRatsit;

    /**
     * Create a new job instance.
     */
    public function __construct($postNumId, $includeRatsit = false)
    {
        $this->postNumId = $postNumId;
        $this->includeRatsit = $includeRatsit;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Find the PostNum record
            $postNum = PostNum::find($this->postNumId);
            if (! $postNum) {
                throw new Exception("PostNum with ID {$this->postNumId} not found");
            }

            $postNummer = str_replace(' ', '', $postNum->post_nummer);

            Log::info("Starting optimized hittaSearchPersons job for: {$postNummer}");

            // Build the optimized command
            $scriptPath = base_path('jobs/hittaSearchPersonsOptimized.mjs');
            $command = "node {$scriptPath} \"{$postNummer}\"";

            // Add --ratsit flag if requested
            if ($this->includeRatsit) {
                $command .= ' --ratsit';
            }

            Log::info("Executing optimized hittaSearchPersons command: {$command}");

            // Execute the script with higher timeout
            $process = new Process(explode(' ', $command));
            $process->setTimeout(1800); // 30 minutes
            $process->setIdleTimeout(300); // 5 minutes idle timeout
            $process->run(function ($type, $buffer) {
                if ($type === Process::ERR) {
                    Log::error('hittaSearchPersons error output: '.$buffer);
                } else {
                    Log::info('hittaSearchPersons output: '.$buffer);
                }
            });

            if (! $process->isSuccessful()) {
                throw new Exception("Script failed with exit code {$process->getExitCode()}: {$process->getErrorOutput()}");
            }

            $output = $process->getOutput();

            Log::info('Optimized hittaSearchPersons script completed', [
                'output' => $output,
                'postNummer' => $postNummer,
                'includeRatsit' => $this->includeRatsit,
            ]);

            // Update the PostNum record to indicate completion
            $postNum->update([
                'status' => 'complete',
                'updated_at' => now(),
            ]);

        } catch (Exception $e) {
            Log::error('RunHittaSearchPersonsOptimizedJob failed', [
                'postNumId' => $this->postNumId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Update status to failed
            if ($postNum = PostNum::find($this->postNumId)) {
                $postNum->update(['status' => 'failed']);
            }

            throw $e;
        }
    }

    /**
     * Custom serialization for PHP 8.1+ compatibility
     */
    public function __serialize(): array
    {
        return [
            'postNumId' => $this->postNumId,
            'includeRatsit' => $this->includeRatsit,
        ];
    }

    /**
     * Custom unserialization for PHP 8.1+ compatibility
     */
    public function __unserialize(array $data): void
    {
        $this->postNumId = $data['postNumId'];
        $this->includeRatsit = $data['includeRatsit'];
    }
}
