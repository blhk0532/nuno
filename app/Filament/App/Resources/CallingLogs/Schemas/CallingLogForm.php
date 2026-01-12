<?php

namespace App\Filament\App\Resources\CallingLogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CallingLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('call_sid'),
                TextInput::make('target_number'),
                TextInput::make('target_name'),
                TextInput::make('duration_seconds')
                    ->numeric(),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('ended_at'),
                TextInput::make('status')
                    ->required()
                    ->default('initiated'),
                TextInput::make('recording_url')
                    ->url(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
