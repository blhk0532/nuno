<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\TeamUsers;

use App\Filament\App\Resources\TeamUsers\Pages\ManageTeamUsers;
use App\Filament\User\Resources\Users\Schemas\UserForm;
use App\Filament\User\Resources\Users\Schemas\UserInfolist;
use App\Filament\User\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

final class TeamUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static bool $isScopedToTenant = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $navigationLabel = 'Teammedlemmar';

    protected static ?string $modelLabel = 'Teammedlem';

    protected static ?string $pluralModelLabel = 'Teammedlemmar';

    protected static string|UnitEnum|null $navigationGroup = 'Projekt';

    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return (string) self::getEloquentQuery()->count();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table)
            ->recordActions([
                Action::make('start_team_chat')
                    ->label('Chat')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->action(function (User $record) {
                        $conversation = auth()->user()->createConversationWith($record);

                        return redirect()->to(route('wirechat.chats.chat', [
                            'conversation' => $conversation->id,
                        ]));
                    }),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $tenantId = filament()->getTenant()?->id
            ?? auth()->user()?->current_team_id;

        return parent::getEloquentQuery()
            ->when($tenantId, function (Builder $query) use ($tenantId) {
                $query->where(function (Builder $query) use ($tenantId) {
                    $query->where('current_team_id', $tenantId)
                        ->orWhereExists(function ($sub) use ($tenantId) {
                            $sub->selectRaw(1)
                                ->from('membership')
                                ->whereColumn('membership.user_id', 'users.id')
                                ->where('membership.team_id', $tenantId);
                        })
                        ->orWhereExists(function ($sub) use ($tenantId) {
                            $sub->selectRaw(1)
                                ->from('teams')
                                ->whereColumn('teams.user_id', 'users.id')
                                ->where('teams.id', $tenantId);
                        });
                });
            })
            ->when(! $tenantId, fn (Builder $query) => $query->whereRaw('1 = 0'));
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTeamUsers::route('/'),
        ];
    }

    public function getHeading(): string
    {
        $tenantName = filament()->getTenant()?->name ?? 'Team';

        return "{$tenantName} - Teammedlemmar";
    }
}
