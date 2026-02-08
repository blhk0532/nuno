<?php

declare(strict_types=1);

namespace App\Filament\App\Widgets;

use App\Filament\App\Resources\TeamUsers\TeamUserResource;
use App\Filament\User\Resources\Users\Tables\UsersTable;
use App\Models\Team;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

final class TeamMembersWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $tenantId = filament()->getTenant()?->id
            ?? auth()->user()?->current_team_id;
        $tenantName = $tenantId ? Team::find($tenantId)?->name ?? 'Team' : 'Team';

        // Log for debugging
        \Illuminate\Support\Facades\Log::info('TeamMembersWidget query', [
            'tenant_id' => $tenantId,
            'tenant_name' => $tenantName,
            'auth_user_id' => auth()->user()?->id,
            'auth_current_team' => auth()->user()?->current_team_id,
        ]);

        return UsersTable::configure($table)
            ->heading("{$tenantName} - Teammedlemmar")
            ->query(function () use ($tenantId) {
                $query = TeamUserResource::getEloquentQuery()->orderBy('name');
                \Illuminate\Support\Facades\Log::info('TeamMembersWidget executed query', [
                    'tenant_id' => $tenantId,
                    'sql' => $query->toSql(),
                    'bindings' => $query->getBindings(),
                    'count' => $query->count(),
                ]);

                return $query;
            })
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
