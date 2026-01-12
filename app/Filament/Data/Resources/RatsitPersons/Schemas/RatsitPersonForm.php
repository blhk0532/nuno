<?php

namespace App\Filament\Data\Resources\RatsitPersons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RatsitPersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Personal Information')
                            ->description('Details about the person')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled(),

                                TextInput::make('age')
                                    ->label('Age')
                                    ->numeric()
                                    ->nullable()
                                    ->disabled(),

                                TextInput::make('street')
                                    ->label('Street')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled(),
                            ])
                            ->columns(3),

                        Section::make('Location')
                            ->description('Address information')
                            ->schema([
                                TextInput::make('city')
                                    ->label('City')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled(),

                                TextInput::make('postal_code')
                                    ->label('Postal Code')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled(),

                                TextInput::make('url')
                                    ->label('Ratsit Profile URL')
                                    ->url()
                                    ->columnSpanFull()
                                    ->disabled(),
                            ])
                            ->columns(2),

                        Section::make('Metadata')
                            ->schema([
                                DateTimePicker::make('scraped_at')
                                    ->label('Scraped At')
                                    ->disabled(),
                            ]),
                    ]),
            ]);
    }
}
