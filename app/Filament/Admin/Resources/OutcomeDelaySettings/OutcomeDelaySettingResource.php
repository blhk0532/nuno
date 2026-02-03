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
use Filament\Tables\Table;
use UnitEnum;

final class OutcomeDelaySettingResource extends Resource
{
    protected static ?string $model = OutcomeDelaySetting::class;

    protected static ?string $navigationLabel = 'Outcome Delay Settings';

    protected static ?string $modelLabel = 'Outcome Delay Setting';

    protected static ?string $pluralModelLabel = 'Outcome Delay Settings';

    protected static string|UnitEnum|null $navigationGroup = 'Call Management';

    protected static ?int $navigationSort = 5;

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
