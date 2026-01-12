<?php

namespace App\Filament\Data\Resources\RatsitAdresser;

use App\Filament\Data\Resources\RatsitAdresser\Pages\ListRatsitAdresser;
use App\Models\RatsitAdress;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class RatsitAdressResource extends Resource
{
    protected static ?string $model = RatsitAdress::class;

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $navigationLabel = 'Ratsit Adresser';

    protected static UnitEnum|string|null $navigationGroup = 'Ratsit Databas';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('post_ort')->searchable()->sortable(),
                TextColumn::make('post_nummer')->searchable()->sortable(),
                TextColumn::make('gatuadress_namn')->label('Gatuadress')->searchable()->sortable(),
                TextColumn::make('personer_count')->label('Personer')->numeric()->sortable(),
                TextColumn::make('foretag_count')->label('Företag')->numeric()->sortable(),
                TextColumn::make('personer_link')->label('Personer Link')->url(fn ($record) => $record->personer_link)->openUrlInNewTab()->toggleable(),
                TextColumn::make('foretag_link')->label('Företag Link')->url(fn ($record) => $record->foretag_link)->openUrlInNewTab()->toggleable(),
                TextColumn::make('updated_at')->dateTime()->since()->sortable()->toggleable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25);
    }

    public static function form(Schema $schema): Schema
    {
        return Schema::make();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRatsitAdresser::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
