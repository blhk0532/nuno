<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeDelaySettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class OutcomeDelaySettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('outcome')
                    ->label('Outcome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('delay_minutes')
                    ->label('Delay (Minutes)')
                    ->sortable(),
                TextColumn::make('max_retry_count')
                    ->label('Max Retries')
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
