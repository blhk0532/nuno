<?php

namespace App\Console\Commands;

use App\Jobs\RunHittaPostOrtDirectJob;
use App\Models\PostNum;
use Illuminate\Console\Command;

class RunHittaPostOrtDirectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hitta:run-direct {postNumId : The ID of the PostNum record} {--max-pages= : Maximum number of pages to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Hitta PostOrt job directly without batches (forced database saves)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $postNumId = $this->argument('postNumId');
        $maxPages = $this->option('max-pages') ? (int) $this->option('max-pages') : null;

        $postNum = PostNum::find($postNumId);
        if (! $postNum) {
            $this->error("PostNum with ID {$postNumId} not found.");

            return 1;
        }

        $this->info('Starting direct Hitta PostOrt job for:');
        $this->line("PostNum: {$postNum->post_nummer}");
        $this->line("PostOrt: {$postNum->post_ort}");
        if ($maxPages) {
            $this->line("Max Pages: {$maxPages}");
        }

        // Dispatch the direct job
        RunHittaPostOrtDirectJob::dispatch($postNumId, $maxPages);

        $this->info('Direct job dispatched successfully!');
        $this->info('Monitor the logs for progress: tail -f storage/logs/laravel.log');

        return 0;
    }
}
