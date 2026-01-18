<?php

namespace App\Filament\App\Widgets;

use Adultdate\FilamentBooking\Models\Booking\Booking;
use App\Filament\App\Resources\Bookings\BookingResource;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class LatestOrders extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
protected static bool $isDiscovered = false;
    protected static ?string $heading = 'Senaste Bokningar';

    protected static ?int $sort = 0;

    public function table(Table $table): Table
    {
        return $table
            ->query(Booking::query()->when(Auth::id(), function ($q, $userId) {
                $q->where(function ($q2) use ($userId) {
                    $q2->where('booking_user_id', $userId)
                        ->orWhere('service_user_id', $userId);
                });
            }))
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Order date')
                    ->date()
                    ->sortable(),
                TextColumn::make('number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('total_price')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('service_date')
                    ->label('Service date')
                    ->date()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('open')
                    ->url(fn (Booking $record): string => BookingResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
