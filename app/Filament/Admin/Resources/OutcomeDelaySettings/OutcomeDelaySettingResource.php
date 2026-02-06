<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeDelaySettings;

use App\Filament\Admin\Resources\OutcomeDelaySettings\Pages\CreateOutcomeDelaySetting;
use App\Filament\Admin\Resources\OutcomeDelaySettings\Pages\EditOutcomeDelaySetting;
use App\Filament\Admin\Resources\OutcomeDelaySettings\Pages\ListOutcomeDelaySettings;
use App\Filament\Admin\Resources\OutcomeDelaySettings\Schemas\OutcomeDelaySettingForm;
use App\Filament\Admin\Resources\OutcomeDelaySettings\Tables\OutcomeDelaySettingsTable;
use App\Models\OutcomeDelaySetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class OutcomeDelaySettingResource extends Resource
{
    protected static ?string $model = OutcomeDelaySetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return OutcomeDelaySettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OutcomeDelaySettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOutcomeDelaySettings::route('/'),
            'create' => CreateOutcomeDelaySetting::route('/create'),
            'edit' => EditOutcomeDelaySetting::route('/{record}/edit'),
        ];
    }
}
