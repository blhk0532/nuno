<?php

namespace App\Filament\App\Resources\Bookings\Pages;

use App\Filament\App\Resources\Bookings\BookingResource;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListBookings extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = BookingResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label('Ny Bokning')
                ->url(fn () => BookingResource::getUrl('create')),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Visa Alla'),
            'bokad' => Tab::make()->query(fn ($query) => $query->where('status', 'booked')),
            'avbokad' => Tab::make()->query(fn ($query) => $query->where('status', 'cancelled')),
            'bekräftad' => Tab::make()->query(fn ($query) => $query->where('status', 'confirmed')),
            'genomförd' => Tab::make()->query(fn ($query) => $query->where('status', 'completed')),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return BookingResource::getWidgets();
    }
}
