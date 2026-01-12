<?php

namespace App\Filament\Data\Resources\Merinfos\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MerinfoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('type')
                            ->required(),
                        TextInput::make('title')
                            ->nullable(),
                        TextInput::make('short_uuid')
                            ->required()
                            ->unique(),
                        Textarea::make('name')
                            ->required()
                            ->rows(2),
                        TextInput::make('givenNameOrFirstName')
                            ->required(),
                        TextInput::make('personalNumber')
                            ->required(),
                        Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ])
                            ->required(),
                    ]),

                Section::make('Address Information')
                    ->schema([
                        Repeater::make('address')
                            ->schema([
                                TextInput::make('street')->required(),
                                TextInput::make('zip_code')->required(),
                                TextInput::make('city')->required(),
                            ])
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['street'] ?? null),
                    ]),

                Section::make('Phone Numbers')
                    ->schema([
                        Repeater::make('phone_number')
                            ->schema([
                                TextInput::make('number')->required(),
                                TextInput::make('raw')->required(),
                                TextInput::make('show_all_url')->nullable(),
                            ])
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['number'] ?? null),
                    ]),

                Section::make('Additional Information')
                    ->columns(2)
                    ->schema([
                        Checkbox::make('is_celebrity'),
                        Checkbox::make('has_company_engagement'),
                        TextInput::make('number_plus_count')
                            ->numeric()
                            ->default(0),
                        Textarea::make('url')
                            ->required()
                            ->rows(2),
                        Textarea::make('same_address_url')
                            ->nullable()
                            ->rows(2),
                    ]),

                Section::make('PNR Details')
                    ->schema([
                        KeyValue::make('pnr')
                            ->keyLabel('Field')
                            ->valueLabel('Value')
                            ->addActionLabel('Add field'),
                    ]),
            ]);
    }
}
