<?php

declare(strict_types=1);

namespace App\Livewire;

use Exception;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Inerba\DbConfig\AbstractPageSettings;

final class UserNotesModal extends AbstractPageSettings implements HasForms
{
    use InteractsWithForms;

    public ?int $currentUser = null;

    public ?array $data = [];

    protected string $view = 'livewire.user-notes-modal';

    public function mount(): void
    {
        $this->currentUser = Auth::id();
        parent::mount();
    }

    public function getDefaultData(): array
    {
        return [];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\RichEditor::make('anteckningar')
                    ->toolbarButtons([
                        ['attachFiles', 'bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'bulletList', 'orderedList'],
                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['blockquote', 'table', 'codeBlock', 'customBlocks', 'mergeTags'],
                        ['undo', 'redo'],
                    ])
                    ->floatingToolbars([
                        'paragraph' => [
                            'bold', 'italic', 'underline', 'strike', 'subscript', 'superscript',
                        ],
                        'heading' => [
                            'h1', 'h2', 'h3',
                        ],
                        'table' => [
                            'tableAddColumnBefore', 'tableAddColumnAfter', 'tableDeleteColumn',
                            'tableAddRowBefore', 'tableAddRowAfter', 'tableDeleteRow',
                            'tableMergeCells', 'tableSplitCell',
                            'tableToggleHeaderRow', 'tableToggleHeaderCell',
                            'tableDelete',
                        ],
                    ])
                    ->label('Mina Anteckningar')
                    ->extraAttributes(['spellcheck' => 'false', 'wire:ignore' => true])
                    ->resizableImages()
                    ->columnSpanFull(),
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
                ->title('Fel')
                ->body($e->getMessage())
                ->send();
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.user-notes-modal');
    }

    protected function settingName(): string
    {
        $userId = Auth::id() ?? 'guest';

        return "user_notes_{$userId}";
    }
}
