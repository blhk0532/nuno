<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Filament\Actions\Exports\Models\Export;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class RequeuePendingExports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exports:requeue-pending {--ids= : Comma-separated list of export IDs to requeue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-queue pending exports that have 0 processed rows';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $exportIds = $this->option('ids') ? explode(',', $this->option('ids')) : null;

        $query = Export::where('processed_rows', 0)
            ->whereNull('completed_at');

        if ($exportIds) {
            $query->whereIn('id', $exportIds);
        }

        $pendingExports = $query->get();

        if ($pendingExports->isEmpty()) {
            $this->info('No pending exports found.');
            return self::SUCCESS;
        }

        $this->info("Found {$pendingExports->count()} pending exports to re-queue.");

        foreach ($pendingExports as $export) {
            $this->line("Re-queuing export ID: {$export->id} ({$export->exporter})");

            // Get the exporter class
            $exporterClass = $export->exporter;

            // Get column map - we'll need to reconstruct this
            // For now, let's use all available columns
            $columnMap = collect($exporterClass::getColumns())
                ->mapWithKeys(fn ($column) => [$column->getName() => $column->getLabel()])
                ->toArray();

            // Get options - we'll use empty options for now
            $options = [];

            // Get the exporter instance
            $exporter = app($exporterClass, [
                'columnMap' => $columnMap,
                'options' => $options,
            ]);

            // Get formats
            $formats = $exporter->getFormats();

            // Get job details - use default PrepareCsvExport job
            $job = \Filament\Actions\Exports\Jobs\PrepareCsvExport::class;
            $jobQueue = $exporter->getJobQueue();
            $jobConnection = $exporter->getJobConnection();
            $jobBatchName = $exporter->getJobBatchName();

            // Create a simple query for all records (this is a limitation - we can't easily reconstruct the original query)
            // For the specific exporters we know about, we can create appropriate queries
            $query = null;
            if (str_contains($exporterClass, 'HittaDataExporter')) {
                $query = \App\Models\HittaData::query();
            } elseif (str_contains($exporterClass, 'RatsitDataExporter')) {
                $query = \App\Models\RatsitData::query();
            } elseif (str_contains($exporterClass, 'PostnummerExporter') || str_contains($exporterClass, 'PostNumExporter')) {
                $query = \App\Models\PostNum::query();
            }

            if (!$query) {
                $this->warn("Cannot determine query for exporter: {$exporterClass}. Skipping export ID: {$export->id}");
                continue;
            }

            // Serialize the query
            $serializedQuery = \AnourValar\EloquentSerialize\Facades\EloquentSerializeFacade::serialize($query);

            // Re-queue the jobs
            Bus::chain([
                Bus::batch([app($job, [
                    'export' => $export,
                    'query' => $serializedQuery,
                    'columnMap' => $columnMap,
                    'options' => $options,
                    'chunkSize' => 100, // Default chunk size
                    'records' => null,
                ])])
                    ->allowFailures()
                    ->when(
                        filled($jobQueue),
                        fn ($batch) => $batch->onQueue($jobQueue),
                    )
                    ->when(
                        filled($jobConnection),
                        fn ($batch) => $batch->onConnection($jobConnection),
                    )
                    ->when(
                        filled($jobBatchName),
                        fn ($batch) => $batch->name($jobBatchName),
                    ),
                ...((in_array(\Filament\Actions\Exports\Enums\ExportFormat::Xlsx, $formats) && (!in_array(\Filament\Actions\Exports\Enums\ExportFormat::Csv, $formats))) ? [app(\Filament\Actions\Exports\Jobs\CreateXlsxFile::class, [
                    'export' => $export,
                    'columnMap' => $columnMap,
                    'options' => $options,
                ])] : []),
                app(\Filament\Actions\Exports\Jobs\ExportCompletion::class, [
                    'authGuard' => 'web', // Default auth guard
                    'export' => $export,
                    'columnMap' => $columnMap,
                    'formats' => $formats,
                    'options' => $options,
                ]),
                ...((in_array(\Filament\Actions\Exports\Enums\ExportFormat::Xlsx, $formats) && in_array(\Filament\Actions\Exports\Enums\ExportFormat::Csv, $formats)) ? [app(\Filament\Actions\Exports\Jobs\CreateXlsxFile::class, [
                    'export' => $export,
                    'columnMap' => $columnMap,
                    'options' => $options,
                ])] : []),
            ])
                ->when(
                    filled($jobQueue),
                    fn ($chain) => $chain->onQueue($jobQueue),
                )
                ->when(
                    filled($jobConnection),
                    fn ($chain) => $chain->onConnection($jobConnection),
                )
                ->dispatch();

            $this->info("Successfully re-queued export ID: {$export->id}");
        }

        $this->info('Re-queuing completed.');
        return self::SUCCESS;
    }
}