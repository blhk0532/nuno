<?php

declare(strict_types=1);

namespace App\Filament\App\Widgets;

use App\Filament\User\Resources\Users\Tables\UsersTable;
use App\Models\Team;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

final class TeamMembersWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $tenantId = filament()->getTenant()?->id;
        $tenantName = $tenantId ? Team::find($tenantId)?->name ?? 'Team' : 'Team';

        return UsersTable::configure($table)
            ->heading("{$tenantName} - Teammedlemmar")
            ->query(
                User::query()
                    ->where(function (Builder $query) use ($tenantId) {
                        $query->whereHas('teams', fn (Builder $q) => $q->where('teams.id', $tenantId))
                            ->orWhereHas('ownedTeams', fn (Builder $q) => $q->where('teams.id', $tenantId));
                    })
            )
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
            ])
            ->paginated(false);
    }
}
