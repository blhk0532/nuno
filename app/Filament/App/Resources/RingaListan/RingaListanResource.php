<?php

namespace App\Filament\App\Resources\RingaListan;

use App\Enums\Outcomes;
use App\Filament\App\Resources\RingaListan\Pages\CreateRingaData;
use App\Filament\App\Resources\RingaListan\Pages\EditRingaData;
use App\Filament\App\Resources\RingaListan\Pages\ListRingaData;
use App\Filament\App\Resources\RingaListan\Pages\ViewRingaData;
use App\Filament\App\Resources\RingaListan\Pages\QueueRingaData;
use App\Filament\App\Resources\RingaListan\Schemas\RingaDataForm;
use App\Filament\App\Resources\RingaListan\Schemas\RingaDataInfolist;
use App\Filament\App\Resources\RingaListan\Tables\RingaDataTable;
use App\Models\RingaData;
use BackedEnum;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RingaListanResource extends Resource
{
    protected static ?string $model = RingaData::class;

    protected static string|BackedEnum|null $navigationIcon = Remix::RiTimerFlashLine;
    protected static string|BackedEnum|null $activeNavigationIcon = Remix::RiTimerFlashFill;


    protected static ?string $navigationLabel = 'Återkom';

    protected static UnitEnum|string|null $navigationGroup = ' ';

    protected static ?string $slug = 'ringa/listan';

    protected static ?int $navigationSort = 12;

    public static bool $shouldRegisterNavigation = true;

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
        return RingaDataTable::configure($table)
            ->query(fn () => RingaData::query()->whereIn('outcome', [
                Outcomes::Aterkommer->value,
                Outcomes::RingTillbaka->value,
            ]));
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
        return 'primary';
    }

    public static function getNavigationBadge(): ?string
    {
        $count = self::$model::query()
            ->whereIn('outcome', self::getTrackedOutcomes())
            ->count();

        return $count ? (string) $count : null;
    }

    private static function getTrackedOutcomes(): array
    {
        return [
            Outcomes::Aterkommer->value,
            Outcomes::RingTillbaka->value,
        ];
    }
}
