<?php

declare(strict_types=1);

namespace App\Filament\Finance\Resources\Users\Schemas;

use App\Enums\AuthRole;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        Select::make('role')
                            ->label('Role')
                            ->options(collect(AuthRole::cases())->mapWithKeys(fn (AuthRole $role) => [
                                $role->value => $role->label(),
                            ])->toArray())
                            ->required()
                            ->default('user'),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('phone')
                            ->columnSpan(1)
                            ->tel(),
                        DateTimePicker::make('email_verified_at')
                            ->columnSpan(2)
                            ->native(true),
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->label('Confirm Password')
                            ->required()
                            ->same('password')
                            ->dehydrated(false)
                            ->columnSpan(2),
                    ]),
                Section::make()
                    ->columnSpan(1)
                    ->schema([
                        Toggle::make('status'),
                    ]),
            ]);
    }
}
