<?php

namespace App\Filament\Data\Resources\PostNums\Pages;

use App\Filament\Data\Resources\PostNums\PostNumResource;
use App\Jobs\BackupPostNums;
use App\Jobs\ImportPostNums;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListPostNums extends ListRecords
{
    protected static string $resource = PostNumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('import')
                ->label('Import Data')
                ->icon('heroicon-o-document-arrow-up')
                ->color('success')
                ->action(function (array $data): void {
                    $this->handleImport($data['file'], $data['file_type']);
                })
                ->form([
                    Select::make('file_type')
                        ->label('File Type')
                        ->options([
                            'csv' => 'CSV',
                            'xlsx' => 'Excel (XLSX/XLS)',
                            'sqlite' => 'SQLite Database',
                        ])
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, Set $set) {
                            $set('file', null); // Clear file when type changes
                        }),

                    FileUpload::make('file')
                        ->label('File')
                        ->required()
                        ->directory('imports')
                        ->visibility('private')
                        ->acceptedFileTypes(function (Get $get) {
                            return match ($get('file_type')) {
                                'csv' => ['text/csv', 'text/plain'],
                                'xlsx' => ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                                'sqlite' => ['application/x-sqlite3', 'application/octet-stream'],
                                default => [],
                            };
                        })
                        ->maxSize(function (Get $get) {
                            return match ($get('file_type')) {
                                'sqlite' => 51200, // 50MB for SQLite
                                default => 10240, // 10MB for others
                            };
                        })
                        ->helperText(function (Get $get) {
                            return match ($get('file_type')) {
                                'csv' => 'Upload a CSV file with headers matching database columns.',
                                'xlsx' => 'Upload an Excel file (.xlsx or .xls) with data in the first sheet.',
                                'sqlite' => 'Upload a SQLite database file containing a post_nums table.',
                                default => '',
                            };
                        }),
                ])
                ->modalHeading('Import Post Nums Data')
                ->modalDescription('Choose a file type and upload your data file to import into the Post Nums database.')
                ->modalSubmitActionLabel('Start Import'),

            Action::make('backupDatabase')
                ->label('Backup DB')
                ->icon('heroicon-o-cloud-arrow-down')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Backup Post Nums Table')
                ->modalDescription('This will queue a background job to create a SQLite backup of the post_nums table in the database/export folder. You will receive a notification when the backup is complete.')
                ->modalSubmitActionLabel('Queue Backup Job')
                ->action(function (): void {
                    try {
                        // Dispatch the backup job
                        BackupPostNums::dispatch();

                        Notification::make()
                            ->title('Backup Job Queued')
                            ->body('The Post Nums data backup job has been queued and will run in the background.')
                            ->success()
                            ->send();

                    } catch (Exception $e) {
                        Notification::make()
                            ->title('Failed to Queue Backup')
                            ->body('Error queuing backup job: '.$e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            CreateAction::make(),
        ];
    }

    protected function handleImport(array $files, string $fileType): void
    {
        $filePath = $files[0]; // FileUpload returns array
        $userId = auth()->id();

        try {
            // Dispatch the appropriate import job
            match ($fileType) {
                'csv' => ImportPostNums::dispatch($filePath, 'csv', $userId),
                'xlsx' => ImportPostNums::dispatch($filePath, 'xlsx', $userId),
                'sqlite' => ImportPostNums::dispatch($filePath, 'sqlite', $userId),
            };

            Notification::make()
                ->title('Import Job Queued')
                ->body("The {$fileType} import job has been queued and will run in the background. You will receive a notification when it completes.")
                ->success()
                ->send();

        } catch (Exception $e) {
            Notification::make()
                ->title('Failed to Queue Import')
                ->body('Error queuing import job: '.$e->getMessage())
                ->danger()
                ->send();
        }
    }
}
