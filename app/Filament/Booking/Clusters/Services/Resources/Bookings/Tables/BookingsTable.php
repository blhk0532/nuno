<?php

declare(strict_types=1);

namespace App\Filament\Booking\Clusters\Services\Resources\Bookings\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Guava\FilamentIconSelectColumn\Tables\Columns\IconSelectColumn;
use Illuminate\Database\Eloquent\Builder;

final class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('total_price')
                    ->searchable()
                    ->sortable()
                    ->summarize([
                        Sum::make()
                            ->money(),
                    ]),
                IconSelectColumn::make('state')
                    ->label('Status')
                    ->options(\Adultdate\FilamentBooking\Enums\BookingState::toOptions())
                    ->icons([
                        \Adultdate\FilamentBooking\Enums\Pending::class => 'heroicon-o-clock',
                        \Adultdate\FilamentBooking\Enums\Paid::class => 'heroicon-o-check',
                        \Adultdate\FilamentBooking\Enums\Failed::class => 'heroicon-o-x-mark',
                    ])
                    ->colors([
                        \Adultdate\FilamentBooking\Enums\Pending::class => ['display' => 'amber-600', 'dropdown' => 'amber-500'],
                        \Adultdate\FilamentBooking\Enums\Paid::class => ['display' => 'green-600', 'dropdown' => 'green-500'],
                        \Adultdate\FilamentBooking\Enums\Failed::class => ['display' => 'red-600', 'dropdown' => 'red-500'],
                    ]),
                TextColumn::make('created_at')
                    ->label('Booking date')
                    ->date()
                    ->toggleable(),
            ])
            ->filters([
                TrashedFilter::make(),

                Filter::make('created_at')
                    ->label('Booking date')
                    ->schema([
                        // keep simple - use Filament datepickers if desired
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query;
                    })
                    ->indicateUsing(function (array $data): array {
                        return [];
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->action(function (): void {
                        Notification::make()
                            ->title('Now, now, don\'t be cheeky, leave some records for others to play with!')
                            ->warning()
                            ->send();
                    }),
            ])
            ->groups([
                Group::make('created_at')
                    ->label('Booking date')
                    ->date()
                    ->collapsible(),
            ]);
    }
}
