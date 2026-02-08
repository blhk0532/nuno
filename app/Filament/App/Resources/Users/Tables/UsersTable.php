<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\Users\Tables;

use App\Enums\AuthRole;
use Awcodes\BadgeableColumn\Components\BadgeableColumn;
use Deldius\UserField\UserColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Guava\FilamentIconSelectColumn\Tables\Columns\IconSelectColumn;
use Mokhosh\FilamentRating\Columns\RatingColumn;
use STS\FilamentImpersonate\Actions\Impersonate;

final class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->label('Skapa Användare')
                    ->extraAttributes(['class' => 'absolute left-4 top-11']),
            ])
            ->columns([
                UserColumn::make('id')
                    ->showActiveState() // Show active/inactive indicator
                    ->avatarUrl(fn ($record) => $record->getFilamentAvatarUrl())
                    ->size(Size::Small) // Set avatar size
                    ->label('User'),
                IconSelectColumn::make('role')
                    ->options(collect(AuthRole::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray())
                    ->icons(collect(AuthRole::cases())->mapWithKeys(function ($case) {
                        $icons = [
                            'admin' => 'heroicon-o-shield-check',
                            'super' => 'heroicon-o-star',
                            'manager' => 'heroicon-o-user-group',
                            'service' => 'heroicon-o-wrench-screwdriver',
                            'booking' => 'heroicon-o-calendar',
                            'partner' => 'heroicon-o-user-circle',
                            'guest' => 'heroicon-o-eye',
                            'user' => 'heroicon-o-user',
                        ];

                        return [$case->value => $icons[$case->value] ?? 'heroicon-o-user'];
                    })->toArray())
                    ->colors(collect(AuthRole::cases())->mapWithKeys(fn ($case) => [$case->value => $case->getColor()])->toArray())
                    ->disabled(fn ($record) => $record->hasRole('super')),
                IconColumn::make('status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BadgeableColumn::make('name')
                    ->separator(':'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('notes')
                    ->label('Anteckningar')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('teams.name')
                    ->label('Team Name')
                    ->badge()
                    ->searchable()
                    ->toggleable(),
                //       RatingColumn::make('rating'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn ($record) => Filament::auth()->user()->hasRole('super_admin') || ! $record->hasRole('super_admin')),
                Impersonate::make(),
                DeleteAction::make()
                    ->visible(fn ($record) => Filament::auth()->user()->hasRole('super_admin') || ! $record->hasRole('super_admin')),
            ]);
    }
}
