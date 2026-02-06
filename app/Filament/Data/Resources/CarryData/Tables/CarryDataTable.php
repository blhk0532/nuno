<?php

declare(strict_types=1);

namespace App\Filament\Data\Resources\CarryData\Tables;

use App\Filament\Exports\CarryDataExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class CarryDataTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('person_lopnr')
                    ->label('Person')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('personnr')
                    ->label('Personnummer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('namn')
                    ->label('Namn')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('adress')
                    ->label('Adress')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('postnr')
                    ->label('Postnummer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ort')
                    ->label('Ort')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('telefon')
                    ->label('Telefon')
                    ->searchable(),
                TextColumn::make('mobiltelefon')
                    ->label('Mobiltelefon')
                    ->searchable(),
                TextColumn::make('epost')
                    ->label('E-post')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('has_email')
                    ->label('Has Email')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('epost')),
                Filter::make('has_mobile')
                    ->label('Has Mobile')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('mobiltelefon')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(CarryDataExporter::class),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
