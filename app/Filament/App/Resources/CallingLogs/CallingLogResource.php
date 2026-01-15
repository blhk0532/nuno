<?php

namespace App\Filament\App\Resources\CallingLogs;

use App\Filament\App\Resources\CallingLogs\Pages\CreateCallingLog;
use App\Filament\App\Resources\CallingLogs\Pages\EditCallingLog;
use App\Filament\App\Resources\CallingLogs\Pages\ListCallingLogs;
use App\Filament\App\Resources\CallingLogs\Schemas\CallingLogForm;
use App\Filament\App\Resources\CallingLogs\Tables\CallingLogsTable;
use App\Models\CallingLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class CallingLogResource extends Resource
{
    protected static ?string $model = CallingLog::class;

    protected static ?string $navigationLabel = 'Samtal';

    protected static ?int $navigationSort = 10;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-phone-arrow-up-right';

    protected static string|UnitEnum|null $navigationGroup = ' ';

    // Disable tenant scoping for this resource (no `team` relationship on CallingLog).
    protected static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return CallingLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CallingLogsTable::configure($table);
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
            'index' => ListCallingLogs::route('/'),
            'create' => CreateCallingLog::route('/create'),
            'edit' => EditCallingLog::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
