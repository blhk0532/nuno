<?php

namespace App\Filament\Data\Resources\Merinfos;

use App\Filament\Data\Resources\Merinfos\Pages\CreateMerinfo;
use App\Filament\Data\Resources\Merinfos\Pages\EditMerinfo;
use App\Filament\Data\Resources\Merinfos\Pages\ListMerinfos;
use App\Filament\Data\Resources\Merinfos\Schemas\MerinfoForm;
use App\Filament\Data\Resources\Merinfos\Tables\MerinfosTable;
use App\Models\Merinfo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MerinfoResource extends Resource
{
    protected static ?string $model = Merinfo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static UnitEnum|string|null $navigationGroup = 'SWE Databas';

    protected static ?string $pluralModelLabel = 'Merinfos Data';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return MerinfoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MerinfosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMerinfos::route('/'),
            'create' => CreateMerinfo::route('/create'),
            'edit' => EditMerinfo::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
