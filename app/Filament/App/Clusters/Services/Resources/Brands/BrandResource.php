<?php

declare(strict_types=1);

namespace App\Filament\App\Clusters\Services\Resources\Brands;

use Adultdate\FilamentBooking\Models\Booking\Brand;
use App\Filament\App\Clusters\Services\Resources\Brands\Pages\CreateBrand;
use App\Filament\App\Clusters\Services\Resources\Brands\Pages\EditBrand;
use App\Filament\App\Clusters\Services\Resources\Brands\Pages\ListBrands;
use App\Filament\App\Clusters\Services\Resources\Brands\RelationManagers\AddressesRelationManager;
use App\Filament\App\Clusters\Services\Resources\Brands\RelationManagers\ServicesRelationManager;
use App\Filament\App\Clusters\Services\Resources\Brands\Schemas\BrandForm;
use App\Filament\App\Clusters\Services\Resources\Brands\Tables\BrandsTable;
use App\Filament\App\Clusters\Services\ServicesCluster;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

final class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $cluster = ServicesCluster::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationParentItem = 'Services';

    protected static ?int $navigationSort = 1;

    protected static bool $isScopedToTenant = false;

    protected static array $relations = [
        ServicesRelationManager::class,
        AddressesRelationManager::class,
    ];

    public static function form(Schema $schema): Schema
    {
        return BrandForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BrandsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBrands::route('/'),
            'create' => CreateBrand::route('/create'),
            'edit' => EditBrand::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'website'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Website' => $record->website,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}
