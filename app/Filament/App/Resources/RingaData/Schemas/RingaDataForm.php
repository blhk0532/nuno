<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaData\Schemas;

use App\Enums\Outcomes;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class RingaDataForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Primary')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('personnamn')
                                    ->label('Full name')
                                    ->columnSpan(2)
                                    ->required(),

                                TextInput::make('fodelsedag')
                                    ->label('Birthdate')
                                    ->placeholder('YYYY-MM-DD')
                                    ->columnSpan(1),

                                TextInput::make('telefon')
                                    ->label('Phone')
                                    ->tel()
                                    ->columnSpan(1),

                                TextInput::make('epost_adress')
                                    ->label('Email')
                                    ->email()
                                    ->columnSpan(1),

                                TextInput::make('personnummer')
                                    ->label('Personnummer')
                                    ->columnSpan(1),
                                TextInput::make('alder')
                                    ->label('Age')
                                    ->numeric()
                                    ->columnSpan(1),
                            ])
                            ->columns(3),
                    ])
                    ->compact()
                    ->collapsible()
                    ->collapsed(true)
                    ->columnSpan(1),

                Section::make('Flags & routing')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->columnSpan(1),

                                Toggle::make('is_queued')
                                    ->label('Queued')
                                    ->columnSpan(1),

                                Select::make('outcome')
                                    ->label('Outcome')
                                    ->options(fn () => collect(Outcomes::cases())->mapWithKeys(
                                        fn (Outcomes $outcome) => [$outcome->value => $outcome->getLabel()]
                                    )->toArray())
                                    ->searchable()
                                    ->native(false)
                                    ->columnSpan(1),
                            ])
                            ->columns(3),
                    ])
                    ->compact()
                    ->collapsible()
                    ->collapsed(true)
                    ->columnSpan(1),

                Section::make('Address')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('gatuadress')->label('Street')->columnSpan(2),
                                TextInput::make('postnummer')->label('ZIP')->columnSpan(1),
                                TextInput::make('postort')->label('City')->columnSpan(1),
                                TextInput::make('kommun')->label('Municipality')->columnSpan(1),
                                TextInput::make('lan')->label('County')->columnSpan(1),
                                TextInput::make('adressandring')->label('Address change')->columnSpan(1),
                            ])
                            ->columns(3),
                    ])
                    ->compact()
                    ->collapsible()
                    ->collapsed(true)
                    ->columnSpan(1),

                Section::make('Property')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('bostadstyp')->label('Type')->columnSpan(1),
                                TextInput::make('boarea')->label('Area (m²)')->numeric()->columnSpan(1),
                                TextInput::make('byggar')->label('Built year')->columnSpan(1),
                                TextInput::make('fastighet')->label('Property')->columnSpan(2),
                                TextInput::make('agandeform')->label('Ownership')->columnSpan(1),
                            ])
                            ->columns(3),
                    ])
                    ->compact()
                    ->collapsible()
                    ->collapsed(true)
                    ->columnSpan(1),

                Section::make('Household')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('personer')->label('People')->numeric()->columnSpan(1),
                                TextInput::make('foretag')->label('Companies')->columnSpan(1),
                                TextInput::make('grannar')->label('Neighbors')->columnSpan(1),
                                TextInput::make('fordon')->label('Vehicles')->columnSpan(1),
                                TextInput::make('hundar')->label('Dogs')->columnSpan(1),
                                TextInput::make('bolagsengagemang')->label('Holdings')->columnSpan(1),
                            ])
                            ->columns(3),
                    ])
                    ->compact()
                    ->collapsible()
                    ->collapsed(true)
                    ->columnSpan(1),

                Section::make('Administrative')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('status')->columnSpan(1),
                                TextInput::make('attempts')->numeric()->columnSpan(1),
                                TextInput::make('booking_id')->numeric()->columnSpan(1),
                                TextInput::make('calendar_id')->numeric()->columnSpan(1),
                                DateTimePicker::make('booked_at')->columnSpan(1)->native(true),
                                DateTimePicker::make('started_at')->required()->columnSpan(1)->native(true),
                                DateTimePicker::make('expires_at')->required()->columnSpan(1)->native(true),
                            ])
                            ->columns(3),
                    ])
                    ->compact()
                    ->collapsed(true)
                    ->collapsible(true)
                    ->columnSpan(1),

                Section::make('Location & external')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('latitud')->label('Latitude')->columnSpan(1),
                                TextInput::make('longitude')->label('Longitude')->columnSpan(1),
                                TextInput::make('ratsit_se')->label('Ratsit URL')->columnSpan(1),
                                TextInput::make('google_maps')->label('Google Maps')->columnSpan(2),
                                TextInput::make('google_streetview')->label('Streetview')->columnSpan(1),
                            ])
                            ->columns(3),
                    ])
                    ->collapsed(true)
                    ->collapsible(true)
                    ->columnSpan(1),

                Section::make('Notes')
                    ->schema([
                        RichEditor::make('user_notes')
                            ->label('Notes')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'link'],
                                ['bulletList', 'orderedList'],
                                ['undo', 'redo'],
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(true)
                    ->columnSpan(1),

                Section::make('Internal')
                    ->schema([
                        TextInput::make('user_id')->columnSpan(1),
                        TextInput::make('service_user_id')->columnSpan(1),

                    ])
                    ->collapsible()
                    ->collapsed(true)
                    ->columns(2)
                    ->columnSpan(1),
                Section::make('More details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('fornamn')->label('First name')->columnSpan(1),
                                TextInput::make('efternamn')->label('Last name')->columnSpan(1),
                                TextInput::make('telfonnummer')->label('Alt. phone')->columnSpan(1),
                                TextInput::make('kon')->label('Gender')->columnSpan(1),
                                TextInput::make('civilstand')->label('Civil status')->columnSpan(1),
                                TextInput::make('stjarntacken')->label('Notes (public)')->columnSpan(1),
                                TextInput::make('forsamling')->label('Parish')->columnSpan(1),
                                TextInput::make('kommun_ratsit')->label('Kommun (Ratsit)')->columnSpan(1),
                            ])
                            ->columns(3),
                    ])
                    ->collapsible()
                    ->collapsed(true)
                    ->columnSpan(1),

            ]);
    }
}
