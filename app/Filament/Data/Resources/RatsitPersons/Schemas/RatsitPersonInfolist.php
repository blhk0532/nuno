<?php

namespace App\Filament\Data\Resources\RatsitPersons\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RatsitPersonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Personal Information')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Full Name')
                                    ->weight('bold')
                                    ->size('lg'),

                                TextEntry::make('age')
                                    ->label('Age')
                                    ->badge()
                                    ->color(fn (?int $state): string => match (true) {
                                        $state === null => 'secondary',
                                        $state >= 60 => 'warning',
                                        $state >= 40 => 'info',
                                        default => 'success',
                                    })
                                    ->formatStateUsing(fn ($state) => $state ? "{$state} years old" : 'Unknown'),
                            ])
                            ->columns(2),

                        Section::make('Location Information')
                            ->schema([
                                TextEntry::make('street')
                                    ->label('Street Address')
                                    ->columnSpanFull(),

                                TextEntry::make('city')
                                    ->label('City')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('postal_code')
                                    ->label('Postal Code')
                                    ->badge()
                                    ->color('warning'),
                            ])
                            ->columns(2),

                        Section::make('Source Information')
                            ->schema([
                                TextEntry::make('url')
                                    ->label('Ratsit Profile URL')
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
