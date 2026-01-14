<?php

namespace App\Filament\Sheets\Resources\BookingOutcallQueues;

use App\Models\BookingOutcallQueue;
use App\Filament\Sheets\Resources\BookingOutcallQueues\Pages\CreateBookingOutcallQueue;
use App\Filament\Sheets\Resources\BookingOutcallQueues\Pages\EditBookingOutcallQueue;
use App\Filament\Sheets\Resources\BookingOutcallQueues\Pages\ListBookingOutcallQueues;
use App\Filament\Sheets\Resources\BookingOutcallQueues\Pages\ViewBookingOutcallQueue;
use App\Filament\Sheets\Resources\BookingOutcallQueues\Schemas\BookingOutcallQueueForm;
use App\Filament\Sheets\Resources\BookingOutcallQueues\Schemas\BookingOutcallQueueInfolist;
use App\Filament\Sheets\Resources\BookingOutcallQueues\Tables\BookingOutcallQueuesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BookingOutcallQueueResource extends Resource
{
    protected static ?string $model = BookingOutcallQueue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedServerStack;

    protected static ?string $navigationLabel = 'Outcall';

    protected static string|UnitEnum|null $navigationGroup = 'UnitEnum';

    protected static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return BookingOutcallQueueForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookingOutcallQueueInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingOutcallQueuesTable::configure($table);
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
            'index' => ListBookingOutcallQueues::route('/'),
            'create' => CreateBookingOutcallQueue::route('/create'),
            'view' => ViewBookingOutcallQueue::route('/{record}'),
            'edit' => EditBookingOutcallQueue::route('/{record}/edit'),
        ];
    }
}
