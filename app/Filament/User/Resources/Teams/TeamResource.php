<?php

namespace App\Filament\User\Resources\Teams;

use App\Filament\User\Resources\Teams\Pages\CreateTeam;
use App\Filament\User\Resources\Teams\Pages\EditTeam;
use App\Filament\User\Resources\Teams\Pages\ListTeams;
use App\Filament\User\Resources\Teams\Pages\ViewTeam;
use App\Filament\User\Resources\Teams\RelationManagers\UsersRelationManager;
use App\Filament\User\Resources\Teams\Schemas\TeamForm;
use App\Filament\User\Resources\Teams\Schemas\TeamInfolist;
use App\Models\Team;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static bool $isGloballySearchable = true;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getGlobalSearchResultUrl($record): string
    {
        return self::getUrl('view', ['record' => $record]);
    }

    public static function getModelLabel(): string
    {
        return __('Team');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Teams');
    }

    public static function getNavigationLabel(): string
    {
        return __('Teams');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Användare');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Cache::rememberForever('teams_count', fn () => Team::query()->count());
    }

    public static function form(Schema $schema): Schema
    {
        return TeamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Add your table columns here, e.g.:
                // Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeams::route('/'),
            'create' => CreateTeam::route('/create'),
            'view' => ViewTeam::route('/{record}'),
            'edit' => EditTeam::route('/{record}/edit'),
        ];
    }
}
