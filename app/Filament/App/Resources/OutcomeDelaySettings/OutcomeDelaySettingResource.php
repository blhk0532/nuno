<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\OutcomeDelaySettings;

use App\Filament\App\Resources\OutcomeDelaySettings\Pages\CreateOutcomeDelaySetting;
use App\Filament\App\Resources\OutcomeDelaySettings\Pages\EditOutcomeDelaySetting;
use App\Filament\App\Resources\OutcomeDelaySettings\Pages\ListOutcomeDelaySettings;
use App\Filament\App\Resources\OutcomeDelaySettings\Pages\ViewOutcomeDelaySetting;
use App\Filament\App\Resources\OutcomeDelaySettings\Schemas\OutcomeDelaySettingForm;
use App\Filament\App\Resources\OutcomeDelaySettings\Schemas\OutcomeDelaySettingInfolist;
use App\Filament\App\Resources\OutcomeDelaySettings\Tables\OutcomeDelaySettingsTable;
use App\Models\OutcomeDelaySetting;
use BackedEnum;
use Closure;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class OutcomeDelaySettingResource extends Resource
{
    protected static ?string $model = OutcomeDelaySetting::class;

    /**
     * This resource is not tenant-owned — disable Filament's tenancy scoping here.
     * Setting $tenantOwnershipRelationshipName to null falls back to the panel default
     * (which expects a `team` relationship). Use the scope flag to opt out.
     */
    protected static bool $isScopedToTenant = false;

    protected static ?string $tenantOwnershipRelationshipName = null;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return OutcomeDelaySettingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OutcomeDelaySettingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OutcomeDelaySettingsTable::configure($table);
    }

    public static function getTableRecordUrlUsing(): ?Closure
    {
        return null;
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
            'index' => ListOutcomeDelaySettings::route('/'),
            'create' => CreateOutcomeDelaySetting::route('/create'),
            'view' => ViewOutcomeDelaySetting::route('/{record}'),
            'edit' => EditOutcomeDelaySetting::route('/{record}/edit'),
        ];
    }
}
