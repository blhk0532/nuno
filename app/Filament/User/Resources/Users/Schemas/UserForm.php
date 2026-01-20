<?php

namespace App\Filament\User\Resources\Users\Schemas;

use App\Enums\AuthRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use function filled;

class UserForm
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
                            ->required()
                            ->string(),
                        Select::make('role')
                            ->label('Role')
                            ->options(collect(AuthRole::cases())->mapWithKeys(fn (AuthRole $role) => [
                                $role->value => $role->label(),
                            ])->toArray())
                            ->required()
                            ->default('user'),
                        TextInput::make('email')
                            ->required()
                            ->string()
                            ->unique('users', 'email', ignoreRecord: true)
                            ->email()
                            ->columnSpan(1),
                        TextInput::make('phone')
                            ->tel(),

                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->minLength(6)
                            ->columnSpan(2),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->label('Confirm Password')
                            ->required(fn (string $context): bool => $context === 'create')
                            ->same('password')
                            ->dehydrated(false)
                            ->columnSpan(2),
                    ]),
                Section::make()
                    ->columnSpan(1)
                    ->schema([
                        Toggle::make('status')
                            ->required(),
                    ]),
            ]);
    }
}
