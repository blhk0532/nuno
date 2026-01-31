<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Exception;
use Illuminate\Support\Facades\Log;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

final class UserNotesModal extends Component implements HasForms
{
    use InteractsWithForms;

    public ?int $currentUser = null;

    public ?array $data = [];

    public string $anteckningar = '';
    protected string $view = 'livewire.user-notes-modal';

    protected $listeners = [
        'userNotesSave' => 'save',
    ];

    public function mount(): void
    {
        $this->currentUser = Auth::id();

        $settingName = $this->settingName();
        $row = DB::table('db_config')->where('key', $settingName)->first();
        if ($row && isset($row->settings)) {
            $settings = json_decode($row->settings, true) ?: [];
            $this->data = $settings;
        }

        // Populate the Filament form with persisted settings so fields (RichEditor) are filled.
        $this->form->fill($this->data ?? []);

        $this->anteckningar = is_string($this->data['anteckningar'] ?? null) ? $this->data['anteckningar'] : '';

        Log::info('UserNotesModal mounted', [
            'user' => $this->currentUser,
            'data_keys' => is_array($this->data) ? array_keys($this->data) : null,
        ]);
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
                    ->extraAttributes(['spellcheck' => 'false'])
                    ->resizableImages()
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $this->form->validate();

            // Read the form state if available, otherwise fall back to the simple `anteckningar` property.
            $state = null;
            try {
                $state = $this->form->getState();
            } catch (\Throwable $t) {
                $state = null;
            }

            if (is_array($state) && array_key_exists('anteckningar', $state)) {
                $this->data = $state;
            } else {
                $this->data = array_merge($this->data ?? [], ['anteckningar' => $this->anteckningar]);
            }

            Log::info('UserNotesModal save called', [
                'user' => $this->currentUser,
                'state_keys' => is_array($state) ? array_keys($state) : null,
            ]);

            $key = $this->settingName();
            DB::table('db_config')->updateOrInsert(
                ['key' => $key],
                ['group' => 'user_notes', 'settings' => json_encode($this->data), 'updated_at' => now()]
            );

            \Filament\Notifications\Notification::make()
                ->success()
                ->title('Sparat')
                ->body('Anteckningar sparade.')
                ->send();
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
