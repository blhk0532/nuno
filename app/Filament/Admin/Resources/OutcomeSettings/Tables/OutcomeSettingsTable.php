<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeSettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

final class OutcomeSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('icon')
                    ->icon(fn ($record) => $record->icon ?? 'heroicon-o-check-badge')
                    ->sortable(),
                ColorColumn::make('color')
                    ->label('Color')
                    ->sortable(),

                TextColumn::make('order')
                    ->label('Order')
                    ->sortable(),
                TextColumn::make('outcome')
                    ->label('Outcome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->searchable()
                    ->hidden()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('access')
                    ->label('Access')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('delay_minutes')
                    ->label('Delay')
                    ->sortable(),
                TextColumn::make('max_retry_count')
                    ->label('Try')
                    ->sortable(),

                TextColumn::make('quarantine_days')
                    ->label('Q Days')
                    ->hidden()
                    ->sortable(),
                ToggleColumn::make('dmc')
                    ->hidden()
                    ->label('DMC'),
                ToggleColumn::make('aterkom')
                    ->hidden()
                    ->label('Återkom'),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('retry')
                    ->label('Retry'),
                ToggleColumn::make('quarantine')
                    ->hidden()
                    ->label('Quarantine'),
                ToggleColumn::make('is_active')
                    ->label('Active'),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
