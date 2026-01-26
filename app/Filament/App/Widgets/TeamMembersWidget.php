<?php

namespace App\Filament\App\Widgets;

use App\Filament\User\Resources\Users\Tables\UsersTable;
use App\Models\User;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action;
use AdultDate\FilamentWirechat\Filament\Pages\ChatPage;

class TeamMembersWidget extends BaseWidget
{
    protected static ?string $heading = 'Teammedlemmar';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return UsersTable::configure($table)
            ->query(
                User::query()
                    ->where(function (Builder $query) {
                        $tenantId = filament()->getTenant()?->id;
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
