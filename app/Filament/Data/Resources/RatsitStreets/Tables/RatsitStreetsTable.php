<?php

namespace App\Filament\Data\Resources\RatsitStreets\Tables;

use App\Models\RatsitStreet;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RatsitStreetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('street_name')
                    ->label('Street')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn (RatsitStreet $record): string => "{$record->city} - {$record->postal_code}"),

                TextColumn::make('city')
                    ->label('City')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('postal_code')
                    ->label('Postal Code')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '44156' => 'success',
                        default => 'warning',
                    }),

                TextColumn::make('person_count')
                    ->label('Persons')
                    ->numeric()
                    ->sortable()
                    ->alignEnd()
                    ->weight('bold')
                    ->formatStateUsing(fn ($state) => number_format($state))
                    ->color('success'),

                TextColumn::make('scraped_at')
                    ->label('Scraped')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('url')
                    ->label('Ratsit Link')
                    ->url(fn (RatsitStreet $record): string => $record->url)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn ($state) => $state ? '🔗 View on Ratsit' : '-')
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->defaultSort('person_count', 'desc')
            ->filters([
                SelectFilter::make('city')
                    ->options(
                        RatsitStreet::distinct()
                            ->pluck('city', 'city')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make('postal_code')
                    ->options(
                        RatsitStreet::distinct()
                            ->pluck('postal_code', 'postal_code')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No streets found')
            ->emptyStateDescription('Import street data from Ratsit scraper to see results here.')
            ->striped();
    }
}
