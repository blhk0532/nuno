<?php

namespace App\Filament\App\Resources\RingaData;

use App\Filament\App\Resources\RingaData\Pages\CreateRingaData;
use App\Filament\App\Resources\RingaData\Pages\EditRingaData;
use App\Filament\App\Resources\RingaData\Pages\ListRingaData;
use App\Filament\App\Resources\RingaData\Pages\ViewRingaData;
use App\Filament\App\Resources\RingaData\Pages\QueueRingaData;
use App\Filament\App\Resources\RingaData\Schemas\RingaDataForm;
use App\Filament\App\Resources\RingaData\Schemas\RingaDataInfolist;
use App\Filament\App\Resources\RingaData\Tables\RingaDataTable;
use App\Models\RingaData;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RingaDataResource extends Resource
{
    protected static ?string $model = RingaData::class;

    protected static string|BackedEnum|null $navigationIcon = Remix::RiStackLine;
    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiStackFill;

    protected static ?string $navigationLabel = 'Nummer';

     protected static UnitEnum|string|null $navigationGroup = 'Mina Sidor';

    protected static ?string $slug = 'nummer/lista';

    protected static ?int $navigationSort = 11;

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

    public static function getEloquentQuery(): Builder
    {
        $userId = auth()->id();
        $tenantId = filament()->getTenant()?->id;

        return parent::getEloquentQuery()
            ->where(function (Builder $query) use ($userId, $tenantId) {
                $query->where(function ($q) use ($userId) {
                    $q->where('user_id', (string) $userId)
                      ->orWhereRaw("FIND_IN_SET(?, user_id)", [$userId]);
                });

                if ($tenantId) {
                    $query->orWhere('team_id', $tenantId);
                }
            });
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

            public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }
}
