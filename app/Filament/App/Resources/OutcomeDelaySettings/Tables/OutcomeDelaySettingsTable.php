<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\OutcomeDelaySettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

final class OutcomeDelaySettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('outcome')
                    ->label('Outcome')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('delay_minutes')
                    ->label('Delay (min)')
                    ->sortable(),

                TextColumn::make('max_retry_count')
                    ->label('Max Retries')
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->wrap()
                    ->limit(80)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // no-op for now
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->extraAttributes(fn ($record) => ['data-open-view' => (string) $record->getKey()]),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
