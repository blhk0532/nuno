<?php

namespace App\Filament\App\Resources\RingaDatas\Tables;

use App\Models\RingaData;
use Faker\Factory as Faker;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class RingaDatasTable
{
    public static function configure(Table $table): Table
    {
        return $table
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
                \Filament\Actions\Action::make('view_details')
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

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

}
