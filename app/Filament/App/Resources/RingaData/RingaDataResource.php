<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaData;

use App\Filament\App\Resources\RingaData\Pages\CreateRingaData;
use App\Filament\App\Resources\RingaData\Pages\EditRingaData;
use App\Filament\App\Resources\RingaData\Pages\ListRingaData;
use App\Filament\App\Resources\RingaData\Pages\QueueRingaData;
use App\Filament\App\Resources\RingaData\Pages\ViewRingaData;
use App\Filament\App\Resources\RingaData\Schemas\RingaDataForm;
use App\Filament\App\Resources\RingaData\Schemas\RingaDataInfolist;
use App\Filament\App\Resources\RingaData\Tables\RingaDataTable;
use App\Models\RingaData;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;

final class RingaDataResource extends Resource
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

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'super' || auth()->user()->role === 'manager') {
            return true;
        }

        return false;

    }

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
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        // Only super OR admin users see all records
        if ($user && in_array($user->role, ['super', 'admin'])) {
            return $query;
        }

        // Everyone else (booking users, regular users) see only their own records or team records
        $userId = $user?->id;
        $tenantId = filament()->getTenant()?->id;

        return $query->where(function (Builder $q) use ($userId, $tenantId) {
            $q->where(function ($nested) use ($userId) {
                $nested->where('user_id', (string) $userId)
                    ->orWhereRaw('FIND_IN_SET(?, user_id)', [$userId]);
            });

            if ($tenantId) {
                $q->orWhere('team_id', $tenantId);
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
            //    'view' => ViewRingaData::route('/{record}'),
            'edit' => EditRingaData::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) self::getEloquentQuery()->count();
    }
}
