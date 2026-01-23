<?php

namespace App\Filament\App\Resources\RingaData;

use App\Filament\App\Resources\RingaData\Pages\CreateRingaData;
use App\Filament\App\Resources\RingaData\Pages\EditRingaData;
use App\Filament\App\Resources\RingaData\Pages\ListRingaData;
use App\Filament\App\Resources\RingaData\Pages\ViewRingaData;
use App\Filament\App\Resources\RingaData\Schemas\RingaDataForm;
use App\Filament\App\Resources\RingaData\Schemas\RingaDataInfolist;
use App\Filament\App\Resources\RingaData\Tables\RingaDataTable;
use App\Models\RingaData;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RingaDataResource extends Resource
{
    protected static ?string $model = RingaData::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // Make this resource global (not tenant-scoped) since Ringa data is public information
    protected static ?string $tenantOwnershipRelationshipName = null;
    protected static bool $isScopedToTenant = false;
    public static function form(Schema $schema): Schema
    {
        return RingaDataForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RingaDataInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RingaDataTable::configure($table);
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
            'index' => ListRingaData::route('/'),
            'create' => CreateRingaData::route('/create'),
            'view' => ViewRingaData::route('/{record}'),
            'edit' => EditRingaData::route('/{record}/edit'),
        ];
    }
}
