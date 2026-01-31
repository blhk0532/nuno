<?php

declare(strict_types=1);

namespace Filament\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Livewire\Concerns\HasTenantMenu;
use Filament\Livewire\Concerns\HasUserMenu;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\Facades\Auth;
use Inerba\DbConfig\Config;

final class Topbar extends Component implements HasActions, HasSchemas
{
    use HasTenantMenu;
    use HasUserMenu;
    use InteractsWithActions;
    use InteractsWithSchemas;

    #[On('refresh-topbar')]
    public function refresh(): void {}

    public function userNotesAction(): Action
    {
        return Action::make('userNotes')
            ->icon('heroicon-o-clipboard-document-list')
            ->color('gray')
            ->label('Kalender')
            ->modalHeading('User Notes')
            ->modalSubmitActionLabel('Spara Anteckningar')
            ->form([
                RichEditor::make('anteckningar')
                    ->label('Mina Anteckningar')
                    ->extraAttributes(['spellcheck' => 'false', 'wire:ignore' => true])
                    ->default(function () {
                        $userId = Auth::id();
                        $settingName = "user_notes_{$userId}";
                        $config = Config::where('name', $settingName)->first();
                        $data = $config ? json_decode($config->value, true) : [];
                        return $data['anteckningar'] ?? '';
                    })
                    ->resizableImages()
                    ->columnSpanFull(),
            ])
            ->action(function (array $data) {
                $userId = Auth::id();
                $settingName = "user_notes_{$userId}";
                $config = Config::firstOrNew(['name' => $settingName]);
                $config->value = json_encode($data);
                $config->save();
                \Filament\Notifications\Notification::make()
                    ->success()
                    ->title('Sparad')
                    ->send();
            });
    }

    public function getActions(): array
    {
        return [
            $this->userNotesAction(),
        ];
    }

    public function render(): View
    {
        return view('filament-panels::livewire.topbar');
    }
}
