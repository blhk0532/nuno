<?php

namespace App\Filament\Data\Resources\RatsitStreets;

use App\Filament\Data\Resources\RatsitStreets\Pages\CreateRatsitStreet;
use App\Filament\Data\Resources\RatsitStreets\Pages\EditRatsitStreet;
use App\Filament\Data\Resources\RatsitStreets\Pages\ListRatsitStreets;
use App\Filament\Data\Resources\RatsitStreets\Pages\ViewRatsitStreet;
use App\Filament\Data\Resources\RatsitStreets\Schemas\RatsitStreetForm;
use App\Filament\Data\Resources\RatsitStreets\Schemas\RatsitStreetInfolist;
use App\Filament\Data\Resources\RatsitStreets\Tables\RatsitStreetsTable;
use App\Models\RatsitStreet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class RatsitStreetResource extends Resource
{
    protected static ?string $model = RatsitStreet::class;

    protected static ?string $recordTitleAttribute = 'street_name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $navigationLabel = 'Ratsit Gatuadress';

    protected static ?int $navigationSort = 7;

    protected static UnitEnum|string|null $navigationGroup = 'Ratsit Databas';

    protected static ?string $slug = 'databaser/ratsit-streets';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return RatsitStreetForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RatsitStreetInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RatsitStreetsTable::configure($table);
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
            'index' => ListRatsitStreets::route('/'),
            'create' => CreateRatsitStreet::route('/create'),
            'view' => ViewRatsitStreet::route('/{record}'),
            'edit' => EditRatsitStreet::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('person_count', 'desc');
    }
}
