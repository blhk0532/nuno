<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\Users\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

use function filled;

final class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Användarnamn')
                            ->required()
                            ->string(),
                        Select::make('role')
                            ->label('Behörighet')
                            ->options(['booking' => 'Mötesbokare'])
                            ->required()
                            ->default('user'),
                        TextInput::make('name_first')
                            ->label('Förnamn')
                            ->required()
                            ->string(),
                        TextInput::make('name_last')
                            ->label('Efternamn')
                            ->required()
                            ->string(),
                        TextInput::make('phone')
                            ->required()
                            ->label('Telefonnummer'),
                        TextInput::make('email')
                            ->required()
                            ->label('E-postadress')
                            ->string()
                            ->unique('users', 'email', ignoreRecord: true)
                            ->email()
                            ->columnSpan(1),
                        TextInput::make('password')
                            ->password()
                            ->label('Skapa Lösenord')
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->minLength(6)
                            ->columnSpan(1),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->label('Bekräfta Lösenord')
                            ->required(fn (string $context): bool => $context === 'create')
                            ->same('password')
                            ->dehydrated(false)
                            ->columnSpan(1),
                        Select::make('assigned_to_id')
                            ->label('Teamleader')
                            ->options(fn () => Auth::user()?->id ? [Auth::user()->id => Auth::user()->name] : [])
                            ->required()
                            ->default('user'),
                        Select::make('author_id')
                            ->label('Skapad av')
                            ->options(fn () => Auth::user()?->id ? [Auth::user()->id => Auth::user()->name] : [])
                            ->required()
                            ->default('user'),
                        Toggle::make('status')
                            ->label('Användarstatus')
                            ->hidden()
                            ->helperText('')
                            ->default(true)
                            ->extraAttributes(['class' => 'mt-8 absolute'])
                            ->required(),
                        MarkdownEditor::make('notes')
                            ->label('Anteckningar')
                            ->nullable()
                            ->string()
                            ->columnSpan(2),

                    ]),
            ]);
    }
}
