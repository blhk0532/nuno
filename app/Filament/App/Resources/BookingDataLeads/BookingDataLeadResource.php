<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\BookingDataLeads;

use App\Filament\App\Resources\BookingDataLeads\Pages\CreateBookingDataLead;
use App\Filament\App\Resources\BookingDataLeads\Pages\EditBookingDataLead;
use App\Filament\App\Resources\BookingDataLeads\Pages\ListBookingDataLeads;
use App\Filament\App\Resources\BookingDataLeads\Pages\ViewBookingDataLead;
use App\Filament\App\Resources\BookingDataLeads\Schemas\BookingDataLeadForm;
use App\Filament\App\Resources\BookingDataLeads\Schemas\BookingDataLeadInfolist;
use App\Filament\App\Resources\BookingDataLeads\Tables\BookingDataLeadsTable;
use App\Models\BookingDataLead;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

final class BookingDataLeadResource extends Resource
{
    protected static ?string $model = BookingDataLead::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-m-user-group';

    protected static ?string $navigationLabel = 'Nummer Listor';

    protected static bool $isScopedToTenant = false;

    protected static UnitEnum|string|null $navigationGroup = 'Mina Sidor';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return BookingDataLeadForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookingDataLeadInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingDataLeadsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookingDataLeads::route('/'),
            'create' => CreateBookingDataLead::route('/create'),
            'view' => ViewBookingDataLead::route('/{record}'),
            'edit' => EditBookingDataLead::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $modelClass = self::$model;

        return (string) $modelClass::count();
    }
}
