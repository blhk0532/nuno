<?php

namespace App\Filament\Data\Resources\RatsitPersons;

use App\Filament\Data\Resources\RatsitPersons\Pages\CreateRatsitPerson;
use App\Filament\Data\Resources\RatsitPersons\Pages\EditRatsitPerson;
use App\Filament\Data\Resources\RatsitPersons\Pages\ListRatsitPersons;
use App\Filament\Data\Resources\RatsitPersons\Pages\ViewRatsitPerson;
use App\Filament\Data\Resources\RatsitPersons\Schemas\RatsitPersonForm;
use App\Filament\Data\Resources\RatsitPersons\Schemas\RatsitPersonInfolist;
use App\Filament\Data\Resources\RatsitPersons\Tables\RatsitPersonsTable;
use App\Models\RatsitPerson;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class RatsitPersonResource extends Resource
{
    protected static ?string $model = RatsitPerson::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?string $navigationLabel = 'Ratsit Personer';

    protected static ?int $navigationSort = 8;

    protected static UnitEnum|string|null $navigationGroup = 'Ratsit Databas';

    protected static ?string $slug = 'databaser/ratsit-persons';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Schema $schema): Schema
    {
        return RatsitPersonForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RatsitPersonInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RatsitPersonsTable::configure($table);
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
            'index' => ListRatsitPersons::route('/'),
            'create' => CreateRatsitPerson::route('/create'),
            'view' => ViewRatsitPerson::route('/{record}'),
            'edit' => EditRatsitPerson::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('name');
    }
}
