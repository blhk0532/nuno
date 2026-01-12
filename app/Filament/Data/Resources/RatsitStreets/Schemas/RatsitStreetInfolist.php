<?php

namespace App\Filament\Data\Resources\RatsitStreets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RatsitStreetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Street Information')
                            ->schema([
                                TextEntry::make('street_name')
                                    ->label('Street Name')
                                    ->weight('bold'),

                                TextEntry::make('postal_code')
                                    ->label('Postal Code')
                                    ->badge(),

                                TextEntry::make('city')
                                    ->label('City')
                                    ->badge(),

                                TextEntry::make('person_count')
                                    ->label('Total Persons')
                                    ->numeric()
                                    ->weight('bold')
                                    ->badge()
                                    ->color('success'),
                            ])
                            ->columns(2),

                        Section::make('Source Information')
                            ->schema([
                                TextEntry::make('url')
                                    ->label('Ratsit URL')
                                    ->url(fn ($state) => $state)
                                    ->openUrlInNewTab()
                                    ->columnSpanFull(),

                                TextEntry::make('scraped_at')
                                    ->label('Data Scraped At')
                                    ->dateTime('F j, Y, g:i a'),

                                TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime('F j, Y, g:i a'),

                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('F j, Y, g:i a'),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }
}
