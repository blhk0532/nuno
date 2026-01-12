<?php

namespace App\Filament\Data\Resources\Merinfos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MerinfosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->limit(50),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                TextColumn::make('givenNameOrFirstName')
                    ->label('First Name')
                    ->searchable(),
                TextColumn::make('personalNumber')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('gender')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'male' => 'info',
                        'female' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('address')
                    ->getStateUsing(function ($record) {
                        $state = $record->address;
                        if (empty($state) || ! is_array($state) || ! isset($state[0])) {
                            return 'N/A';
                        }
                        $address = $state[0];
                        $parts = [];
                        if (isset($address['street'])) {
                            $parts[] = $address['street'];
                        }
                        if (isset($address['zip_code'])) {
                            $parts[] = $address['zip_code'];
                        }
                        if (isset($address['city'])) {
                            $parts[] = $address['city'];
                        }

                        return implode(', ', $parts) ?: 'N/A';
                    })
                    ->limit(50)
                    ->searchable(false)
                    ->sortable(false),
                TextColumn::make('phone_number')
                    ->getStateUsing(function ($record) {
                        $state = $record->phone_number;
                        if (empty($state) || ! is_array($state) || ! isset($state[0])) {
                            return 'N/A';
                        }

                        return $state[0]['number'] ?? $state[0]['raw'] ?? 'N/A';
                    })
                    ->copyable()
                    ->searchable(false)
                    ->sortable(false),
                IconColumn::make('is_celebrity')
                    ->boolean(),
                IconColumn::make('has_company_engagement')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'person' => 'Person',
                        'company' => 'Company',
                    ]),
                SelectFilter::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
