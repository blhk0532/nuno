<?php

declare(strict_types=1);

namespace App\Livewire;

use Exception;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Inerba\DbConfig\AbstractPageSettings;

final class UserNotesWorking extends AbstractPageSettings implements HasSchemas
{
    use InteractsWithSchemas;

    public bool $slideOverOpen = false;

    public ?array $data = [];

    protected string $view = 'livewire.user-notes-working';

    protected $listeners = ['open-user-notes-working' => 'openModal'];

    public function getDefaultData(): array
    {
        return [];
    }

    public function openModal(): void
    {
        $this->slideOverOpen = true;
    }

    public function closeModal(): void
    {
        $this->slideOverOpen = false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\RichEditor::make('notes')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['blockquote', 'codeBlock', 'customBlocks', 'bulletList', 'orderedList'],
                        ['table', 'attachFiles'],
                        ['undo', 'redo'],
                    ])
                    ->label('My Notes')
                    ->columnSpanFull(),
                Action::make('save')
                    ->hidden()
                    ->action(function () {
                        $this->save();
                    })
                    ->label('Save'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $this->form->validate();
            parent::save();
            $this->skipRender();
        } catch (Exception $e) {
            \Filament\Notifications\Notification::make()
                ->danger()
                ->title('Error')
                ->body($e->getMessage())
                ->send();
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.user-notes-working');
    }

    protected function settingName(): string
    {
        $userId = Auth::id() ?? 'guest';

        return "user_notes_working_{$userId}";
    }
}
