<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\User;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;

class TeamInfo extends MyProfileComponent
{
    protected string $view = 'livewire.team-info';

    public array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Team Membership')
                    ->description('Teams you belong to and your roles within them')
                    ->schema([
                        \Filament\Forms\Components\Textarea::make('teams_info')
                            ->label('Your Teams')
                            ->default(function (): string {
                                /** @var User|null $user */
                                $user = Auth::user();

                                if (! $user instanceof User) {
                                    return 'Please log in to view your teams';
                                }

                                $teams = $user->teams()
                                    ->with('owner')
                                    ->orderBy('name')
                                    ->get();

                                if ($teams->isEmpty()) {
                                    return 'You are not a member of any teams';
                                }

                                return $teams->map(function (Team $team) use ($user) {
                                    $role = $team->pivot->role ?? 'member';
                                    $ownerIndicator = $team->isOwner($user) ? ' (Owner)' : '';

                                    return "{$team->name} - {$role}{$ownerIndicator}";
                                })->join(PHP_EOL);
                            })
                            ->disabled()
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }
}
