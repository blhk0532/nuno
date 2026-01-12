<?php

namespace App\Filament\Data\Resources\CarryData;

use App\Filament\Data\Resources\CarryData\Pages\CreateCarryData;
use App\Filament\Data\Resources\CarryData\Pages\EditCarryData;
use App\Filament\Data\Resources\CarryData\Pages\ListCarryData;
use App\Filament\Data\Resources\CarryData\Schemas\CarryDataForm;
use App\Filament\Data\Resources\CarryData\Tables\CarryDataTable;
use App\Models\CarryData;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CarryDataResource extends Resource
{
    protected static ?string $model = CarryData::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Carry Databas';

    protected static ?string $modelLabel = 'Carry Data ';

    protected static ?string $pluralModelLabel = 'Carry Databas';

    protected static UnitEnum|string|null $navigationGroup = 'SWE Databas';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return CarryDataForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CarryDataTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCarryData::route('/'),
            'create' => CreateCarryData::route('/create'),
            'edit' => EditCarryData::route('/{record}/edit'),
        ];
    }
}
