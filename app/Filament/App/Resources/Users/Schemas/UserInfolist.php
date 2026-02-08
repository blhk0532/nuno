<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\Users\Schemas;

use Anish\TextInputEntry\Infolists\Components\TextInputEntry;
use App\Filament\Schemas\Components\AdditionalInformation;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Auth;

final class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->columns()
                    ->schema([
                        TextEntry::make('id'),
                        IconEntry::make('status')
                            ->boolean(),
                        TextInputEntry::make('name')
                            ->editable(true)
                            ->size(TextSize::Large)
                            ->rules(['required', 'string', 'max:255'])
                            ->border(true),

                        TextInputEntry::make('email')
                            ->editable(Auth::user()->can('update email'))
                            ->label('Email address')
                            ->rules(['required', 'email'])
                            ->border(true),
                    ]),
                AdditionalInformation::make([
                    'created_at',
                    'updated_at',
                ]),
            ]);
    }
}
