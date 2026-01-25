<?php

namespace App\Filament\App\Resources\RingaDatas;

use App\Filament\App\Resources\RingaDatas\Pages\CreateRingaData;
use App\Filament\App\Resources\RingaDatas\Pages\EditRingaData;
use App\Filament\App\Resources\RingaDatas\Pages\ListRingaData;
use App\Filament\App\Resources\RingaDatas\Pages\ViewRingaData;
use App\Filament\App\Resources\RingaDatas\Pages\QueueRingaData;
use App\Filament\App\Resources\RingaDatas\Schemas\RingaDataForm;
use App\Filament\App\Resources\RingaDatas\Schemas\RingaDataInfolist;
use App\Filament\App\Resources\RingaDatas\Tables\RingaDataTable;
use App\Models\RingaData;
use BackedEnum;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RingaDatasResource extends Resource
{
    protected static ?string $model = RingaData::class;

    protected static string|BackedEnum|null $navigationIcon = Remix::RiTimerFlashLine;
    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiTimerFlashFill;


    protected static ?string $navigationLabel = 'Återkomsten';

    protected static UnitEnum|string|null $navigationGroup = ' ';

    protected static ?string $slug = 'ringa/data';

    protected static ?int $navigationSort = 10;

    public static bool $shouldRegisterNavigation = false;

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
            'queue' => QueueRingaData::route('/queue'),
            'view' => ViewRingaData::route('/{record}'),
            'edit' => EditRingaData::route('/{record}/edit'),
        ];
    }
}
