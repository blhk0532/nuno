<?php

namespace App\Filament\Data\Resources\HittaDatas;

use App\Filament\Data\Resources\HittaDatas\Pages\CreateHittaData;
use App\Filament\Data\Resources\HittaDatas\Pages\EditHittaData;
use App\Filament\Data\Resources\HittaDatas\Pages\ListHittaDatas;
use App\Filament\Data\Resources\HittaDatas\Pages\ViewHittaData;
use App\Filament\Data\Resources\HittaDatas\Schemas\HittaDataForm;
use App\Filament\Data\Resources\HittaDatas\Tables\HittaDatasTable;
use App\Models\HittaData;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class HittaDataResource extends Resource
{
    protected static ?string $model = HittaData::class;

    protected static ?string $recordTitleAttribute = 'personnamn';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Hitta Databas';

    protected static ?string $modelLabel = 'Hitta Databas';

    protected static ?string $pluralModelLabel = 'Hitta Databaser';

    protected static UnitEnum|string|null $navigationGroup = 'SWE Databas';

    protected static ?int $navigationSort = 4;

    // place resource under Databaser cluster
    protected static ?string $slug = 'databaser/hitta-data';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return HittaDataForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HittaDatasTable::configure($table);
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
            'index' => ListHittaDatas::route('/'),
            'create' => CreateHittaData::route('/create'),
            'view' => ViewHittaData::route('/{record}'),
            'edit' => EditHittaData::route('/{record}/edit'),
        ];
    }
}
