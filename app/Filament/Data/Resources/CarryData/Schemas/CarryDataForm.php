<?php

namespace App\Filament\Data\Resources\CarryData\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;

class CarryDataForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('person_lopnr')
                                    ->label('Person Löpnr'),
                                TextInput::make('personnr')
                                    ->label('Personnummer'),
                                TextInput::make('kon')
                                    ->label('Kön'),
                                TextInput::make('civilstand')
                                    ->label('Civilstånd'),
                                TextInput::make('namn')
                                    ->label('Namn'),
                                TextInput::make('fornamn')
                                    ->label('Förnamn'),
                                TextInput::make('efternamn')
                                    ->label('Efternamn'),
                            ]),
                    ]),
                Section::make('Address Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('adress')
                                    ->label('Adress')
                                    ->columnSpan(2),
                                TextInput::make('co_adress')
                                    ->label('C/O Adress')
                                    ->columnSpan(2),
                                TextInput::make('postnr')
                                    ->label('Postnummer'),
                                TextInput::make('ort')
                                    ->label('Ort'),
                            ]),
                    ]),
                Section::make('Contact Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('telefon')
                                    ->label('Telefon')
                                    ->tel(),
                                TextInput::make('mobiltelefon')
                                    ->label('Mobiltelefon')
                                    ->tel(),
                                TextInput::make('telefax')
                                    ->label('Telefax'),
                                TextInput::make('epost')
                                    ->label('E-post')
                                    ->email(),
                                TextInput::make('epost_privat')
                                    ->label('E-post Privat')
                                    ->email(),
                                TextInput::make('epost_sekundar')
                                    ->label('E-post Sekundär')
                                    ->email(),
                            ]),
                    ]),
            ]);
    }
}
