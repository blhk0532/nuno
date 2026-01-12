<?php

namespace App\Filament\Data\Resources\HittaSes;

use App\Filament\Data\Resources\HittaSes\Pages\CreateHittaSe;
use App\Filament\Data\Resources\HittaSes\Pages\EditHittaSe;
use App\Filament\Data\Resources\HittaSes\Pages\ListHittaSes;
use App\Filament\Data\Resources\HittaSes\Schemas\HittaSeForm;
use App\Filament\Data\Resources\HittaSes\Tables\HittaSesTable;
use App\Models\HittaSe;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class HittaSeResource extends Resource
{
    protected static ?string $model = HittaSe::class;

    //    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Hitta Personer ';

    protected static UnitEnum|string|null $navigationGroup = 'SWE Databas';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    // Icon shown before the navigation group title (Filament v4+)
    protected static string|UnitEnum|null $navigationGroupIcon = Heroicon::MapPin;

    protected static ?string $modelLabel = 'Hitta Person';

    protected static ?string $pluralModelLabel = 'Hitta Personer';

    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return HittaSeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HittaSesTable::configure($table);
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
            'index' => ListHittaSes::route('/'),
            'create' => CreateHittaSe::route('/create'),
            'edit' => EditHittaSe::route('/{record}/edit'),
        ];
    }
}
