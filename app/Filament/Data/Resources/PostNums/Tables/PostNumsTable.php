<?php

namespace App\Filament\Data\Resources\PostNums\Tables;

use App\Filament\Data\Resources\PostNums\Actions\BulkResetValuesBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\CheckDbCountsBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\CountMerinfoBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\MerinfoCountBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\QueueMerinfoBulkAction;
// use App\Filament\Data\Resources\PostNums\Actions\MerinfoCountBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\ResetMerinfoQueueBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\RunAllCountsBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\RunBothCountsBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\RunHittaCountsBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\RunHittaPersonerBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\RunHittaPortOrtBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\RunHittaPortOrtDirectBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\RunHittaSearchBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\RunRatsitCountsBulkAction;
use App\Filament\Data\Resources\PostNums\Actions\RunRatsitPersonerBulkAction;
use App\Filament\Exports\PostNumExporter;
// use App\Filament\Data\Resources\PostNums\Actions\RunHittaPersonsBulkAction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class PostNumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('post_nummer')
                    ->label('Post Nr')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('post_ort')
                    ->label('Post Ort')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('post_lan')
                    ->label('Post Län')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ColumnGroup::make('Hitta', [
                    TextColumn::make('hitta_personer_total')
                        ->label('🌐')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—'),
                    TextColumn::make('hitta_foretag_total')
                        ->label('🏛️🌐')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—')
                        ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('hitta_personer_saved')
                        ->label('💾')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—'),

                    TextColumn::make('hitta_foretag_saved')
                        ->label('🏛️💾')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—')
                        ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('hitta_personer_phone_saved')
                        ->label('☎️')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—'),

                    TextColumn::make('hitta_personer_house_saved')
                        ->label('🏠')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—'),
                ]),

                ColumnGroup::make('Ratsit', [
                    TextColumn::make('ratsit_personer_total')
                        ->label('🌐')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—'),

                    TextColumn::make('ratsit_foretag_total')
                        ->label('🏛️🌐')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—')
                        ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('ratsit_personer_saved')
                        ->label('💾')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—'),

                    TextColumn::make('ratsit_foretag_saved')
                        ->label('🏛️💾')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—')
                        ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('ratsit_personer_phone_saved')
                        ->label('☎️')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—'),

                    TextColumn::make('ratsit_personer_house_saved')
                        ->label('🏠')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—'),
                ]),

                ColumnGroup::make('Merinfo', [
                    TextColumn::make('merinfo_personer_total')
                        ->label('🌐')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—'),

                    TextColumn::make('merinfo_foretag_total')
                        ->label('🏛️🌐')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—')
                        ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('merinfo_personer_phone_total')
                        ->label('☎️')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—')
                        ->toggleable(isToggledHiddenByDefault: false),

                    TextColumn::make('merinfo_personer_saved')
                        ->label('💾')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—')
                        ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('merinfo_foretag_saved')
                        ->label('🏛️💾')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—')
                        ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('merinfo_personer_phone_saved')
                        ->label('☎️')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—')
                        ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('merinfo_personer_house_saved')
                        ->label('🏠')
                        ->numeric()
                        ->sortable()
                        ->toggleable()
                        ->placeholder('—')
                        ->toggleable(isToggledHiddenByDefault: true),

                    IconColumn::make('merinfo_personer_queue')
                        ->label('📅')
                        ->boolean()
                        ->toggleable(),
                ]),

                IconColumn::make('is_active')
                    ->label('⩇⩇:⩇⩇')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->paginated([10, 25, 50, 100, 200, 500, 1000])
            ->defaultPaginationPageOption(25)
            ->defaultSort('post_ort', 'asc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'running' => 'Running',
                        'complete' => 'Complete',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Active')->default(true),

                TernaryFilter::make('has_phone')
                    ->label('Show Phone Only')
                    ->default(true)
                    ->queries(
                        true: fn ($query) => $query->where(function ($q) {
                            $q->where('hitta_personer_phone_saved', '>', 0)
                                ->orWhere('ratsit_personer_phone_saved', '>', 0)
                                ->orWhere('merinfo_personer_phone_saved', '>', 0);
                        }),
                        false: fn ($query) => $query->where(function ($q) {
                            $q->where('hitta_personer_phone_saved', '=', 0)
                                ->where('ratsit_personer_phone_saved', '=', 0)
                                ->where('merinfo_personer_phone_saved', '=', 0);
                        }),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->persistFiltersInSession()
            ->columnToggleFormColumns(3)
            ->columnToggleFormWidth('4xl')
            ->actions([
                //    ViewAction::make(),

                // Action::make('run')
                //     ->label('Run')
                //     ->icon('heroicon-o-play')
                //     ->color('success')
                //     ->requiresConfirmation()
                //     ->modalHeading('Queue Ratsit/Hitta Scraper')
                //     ->modalDescription(fn ($record) => "This will queue the post_ort_update.mjs script for post nummer: {$record->post_nummer}. The job will run in the background.")
                //     ->modalSubmitActionLabel('Queue Job')
                //     ->action(function ($record) {
                //         // Set status to running
                //         $record->update(['status' => 'running']);

                //         // Create job with name and dispatch to queue
                //         $job = new RunPostNumChecksJob($record->id);
                //         dispatch($job);

                //         // Update job name in database after dispatching
                //         DB::table('jobs')
                //             ->where('queue', 'postnummer-checks')
                //             ->orderBy('id', 'desc')
                //             ->limit(1)
                //             ->update(['name' => 'Postnummer: ' . $record->post_nummer]);

                //         Notification::make()
                //             ->title('Kontroller har startats')
                //             ->body("Postnummer {$record->post_nummer} kontroller har lagts i kön och körs i bakgrunden.")
                //             ->info()
                //             ->send();
                //     })
                //     ->visible(fn ($record) => $record->status !== 'running' && $record->status !== 'complete' && $record->status !== 'empty'),

                // Action::make('runHittaSearch')
                //     ->label('Hitta')
                //     ->icon('heroicon-o-magnifying-glass')
                //     ->color('info')
                //     ->requiresConfirmation()
                //     ->modalHeading('Queue Hitta.se Person Search')
                //     ->modalDescription(fn ($record) => "This will queue the hittaSearchPersons.mjs script for post nummer: {$record->post_nummer}. This will scrape person data from Hitta.se and may take several minutes.")
                //     ->modalSubmitActionLabel('Queue Search')
                //     ->action(function ($record) {
                //         // Set status to running
                //         $record->update(['status' => 'running']);

                //         // Create job and dispatch to queue
                //         $job = new RunHittaSearchPersonsJob($record->id, false); // false = no ratsit
                //         dispatch($job)->onQueue('default');

                //         // Update job name in database after dispatching
                //         DB::table('jobs')
                //             ->where('queue', 'default')
                //             ->orderBy('id', 'desc')
                //             ->limit(1)
                //             ->update(['name' => 'Postnummer: ' . $record->post_nummer]);

                //         Notification::make()
                //             ->title('Hitta.se sökning har startats')
                //             ->body("Postnummer {$record->post_nummer} person sökning har lagts i kön och körs i bakgrunden.")
                //             ->info()
                //             ->send();
                //     })
                //     ->visible(fn ($record) => $record->status !== 'running'),

                // Action::make('runHittaSearchWithRatsit')
                //     ->label('H+R')
                //     ->icon('heroicon-o-users')
                //     ->color('warning')
                //     ->requiresConfirmation()
                //     ->modalHeading('Queue Hitta.se + Ratsit Person Search')
                //     ->modalDescription(fn ($record) => "This will queue the hittaSearchPersons.mjs script with Ratsit integration for post nummer: {$record->post_nummer}. This will scrape person data from both Hitta.se and Ratsit.se and may take considerable time.")
                //     ->modalSubmitActionLabel('Queue Search')
                //     ->action(function ($record) {
                //         // Set status to running
                //         $record->update(['status' => 'running']);

                //         // Create job and dispatch to queue
                //         $job = new RunHittaSearchPersonsJob($record->id, true); // true = include ratsit
                //         dispatch($job)->onQueue('hitta-search');

                //         // Update job name in database after dispatching
                //         DB::table('jobs')
                //             ->where('queue', 'hitta-search')
                //             ->orderBy('id', 'desc')
                //             ->limit(1)
                //             ->update(['name' => 'Postnummer: ' . $record->post_nummer]);

                //         Notification::make()
                //             ->title('Hitta.se + Ratsit sökning har startats')
                //             ->body("Postnummer {$record->post_nummer} kombinerad sökning har lagts i kön och körs i bakgrunden.")
                //             ->warning()
                //             ->send();
                //     })
                //     ->visible(fn ($record) => $record->status !== 'running'),

                EditAction::make(),
            ])
            ->toolbarActions([

                BulkActionGroup::make([
                    CheckDbCountsBulkAction::make(),
                    //    MerinfoCountBulkAction::make(),
                    ExportBulkAction::make()
                        ->label('Export Data')
                        ->exporter(PostNumExporter::class),
                    BulkResetValuesBulkAction::make(),
                    QueueMerinfoBulkAction::make(),
                    RunHittaSearchBulkAction::make(),
                    CountMerinfoBulkAction::make(),
                    RunHittaCountsBulkAction::make(),
                    RunRatsitCountsBulkAction::make(),
                    RunBothCountsBulkAction::make(),
                    RunAllCountsBulkAction::make(),
                    RunHittaPersonerBulkAction::make(),
                    RunHittaPortOrtBulkAction::make(),
                    RunHittaPortOrtDirectBulkAction::make(),
                    //    RunHittaPersonsBulkAction::make(),
                    // ResetMerinfoQueueBulkAction::make(),
                    RunRatsitPersonerBulkAction::make(),
                    // RunRatsitPersonerBulkAction::make(),

                ]),

                Action::make('refreshTable')
                    ->label('Refresh Data')
                    ->icon('heroicon-o-arrow-path')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->modalHeading('Refresh Database Counts')
                    ->modalDescription('This will check and update database counts for the selected records. This may take a few moments.')
                    ->modalSubmitActionLabel('Refresh Counts')
                    ->deselectRecordsAfterCompletion()
                    ->successRedirectUrl(request()->fullUrl()),

            ]);

    }
}
