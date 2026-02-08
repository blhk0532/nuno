<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Tables;

use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class RingaDatasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('gatuadress', 'asc')
            ->toolbarActions([
            ])
            ->headerActions([

            ])
            ->columns([
                TextColumn::make('gatuadress')
                    ->sortable(),
                TextColumn::make('fornamn')
                    ->sortable(),

                TextColumn::make('efternamn')
                    ->sortable(),
                TextColumn::make('telefon'),

                TextColumn::make('outcome')
                    ->sortable()
                    ->badge(),
                TextColumn::make('attempts')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('expires_at')
                    ->dateTime()
                    ->hidden()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->hidden()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->hidden()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Actions\Action::make('view_details')
                    ->label('Ring')
                    ->icon('heroicon-o-phone-arrow-up-right')
                    ->color('primary')
                    ->action(function ($record, $livewire) {
                        if (method_exists($livewire, 'selectRecord')) {
                            $livewire->selectRecord($record->id);
                        }
                    }),
                ViewAction::make(),
                EditAction::make(),
            ]);
    }

    private function getHeaderActions(): array
    {
        return [

        ];
    }
}
