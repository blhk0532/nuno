<?php

namespace App\Filament\Data\Resources\RatsitPersons\Tables;

use App\Models\RatsitPerson;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RatsitPersonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->limit(30)
                    ->description(fn (RatsitPerson $record): string => $record->street),

                TextColumn::make('age')
                    ->label('Age')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color(fn (?int $state): string => match (true) {
                        $state === null => 'secondary',
                        $state >= 60 => 'warning',
                        $state >= 40 => 'info',
                        default => 'success',
                    })
                    ->formatStateUsing(fn ($state) => $state ?? 'N/A'),

                TextColumn::make('street')
                    ->label('Street')
                    ->searchable()
                    ->sortable()
                    ->limit(25)
                    ->toggleable(),

                TextColumn::make('postal_code')
                    ->label('Postal Code')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('warning'),

                TextColumn::make('city')
                    ->label('City')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('scraped_at')
                    ->label('Scraped')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('url')
                    ->label('Ratsit Profile')
                    ->url(fn (RatsitPerson $record): string => $record->url)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn ($state) => $state ? '🔗 View Profile' : '-')
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
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('city')
                    ->options(
                        RatsitPerson::distinct()
                            ->pluck('city', 'city')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make('postal_code')
                    ->options(
                        RatsitPerson::distinct()
                            ->pluck('postal_code', 'postal_code')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make('street')
                    ->options(
                        RatsitPerson::distinct()
                            ->orderBy('street')
                            ->pluck('street', 'street')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload(),

                Filter::make('age_range')
                    ->label('Age Range')
                    ->form([
                        TextInput::make('min_age')
                            ->label('Min Age')
                            ->numeric()
                            ->placeholder('e.g. 18'),
                        TextInput::make('max_age')
                            ->label('Max Age')
                            ->numeric()
                            ->placeholder('e.g. 65'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['min_age'] ?? null,
                                fn ($q) => $q->where('age', '>=', $data['min_age'])
                            )
                            ->when(
                                $data['max_age'] ?? null,
                                fn ($q) => $q->where('age', '<=', $data['max_age'])
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No persons found')
            ->emptyStateDescription('Import person data from Ratsit scraper to see results here.')
            ->striped();
    }
}
