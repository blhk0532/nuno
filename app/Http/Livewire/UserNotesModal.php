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
        $row = DB::table('db_config')
            ->where('group', 'user_notes')
            ->where('key', $settingName)
            ->first();
        if ($row && isset($row->settings)) {
            $settings = json_decode($row->settings, true) ?: [];
            $this->data = $settings;
        }

        // Normalize `anteckningar` to a string if it was stored as an array/object or JSON string.
        if (isset($this->data['anteckningar'])) {
            $a = $this->data['anteckningar'];
            if (is_string($a)) {
                if (str_contains($a, '"type":"doc"') || str_contains($a, '"content":')) {
                    $decoded = json_decode($a, true);
                    if (is_array($decoded) && isset($decoded['type']) && $decoded['type'] === 'doc') {
                        $this->data['anteckningar'] = $this->prosemirrorDocToHtml($decoded);
                    }
                }
            } elseif (is_array($a)) {
                if (isset($a['html']) && is_string($a['html'])) {
                    $this->data['anteckningar'] = $a['html'];
                } elseif (isset($a['content']) && is_string($a['content'])) {
                    $this->data['anteckningar'] = $a['content'];
                } elseif (isset($a['type']) && $a['type'] === 'doc') {
                    $this->data['anteckningar'] = $this->prosemirrorDocToHtml($a);
                } else {
                    $this->data['anteckningar'] = json_encode($a);
                }
            }
        }

        // Populate the Filament form with persisted settings so fields (RichEditor) are filled.
        $this->form->fill($this->data ?? []);

        // Ensure the simple property mirrors the filled form state so wire:model works.
        $this->anteckningar = is_string($this->data['anteckningar'] ?? null) ? $this->data['anteckningar'] : '';

        try {
            $formState = $this->form->getState();
        } catch (\Throwable $t) {
            $formState = null;
        }

        Log::info('UserNotesModal mounted', [
            'user' => $this->currentUser,
            'data_keys' => is_array($this->data) ? array_keys($this->data) : null,
            'data_preview' => is_string($this->data['anteckningar'] ?? null) ? mb_substr($this->data['anteckningar'], 0, 200) : null,
            'form_state_keys' => is_array($formState) ? array_keys($formState) : null,
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
                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['blockquote', 'codeBlock', 'customBlocks', 'mergeTags', 'bulletList', 'orderedList'],
                        ['table', 'attachFiles'],
                        ['undo', 'redo'],
                    ])
                    ->label('Mina Anteckningar!')
                    ->extraAttributes(['spellcheck' => 'false', 'wire:ignore' => true])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        Log::info('UserNotesModal save invoked', ['user' => $this->currentUser]);

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
            $result = DB::table('db_config')->updateOrInsert(
                ['group' => 'user_notes', 'key' => $key],
                ['group' => 'user_notes', 'key' => $key, 'settings' => json_encode($this->data), 'updated_at' => now()]
            );

            Log::info('UserNotesModal db_updateOrInsert', ['user' => $this->currentUser, 'key' => $key, 'result' => $result]);

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

    private function prosemirrorDocToHtml(array $node): string
    {
        $map = function ($n) use (&$map) {
            if (!is_array($n)) {
                return '';
            }
            $type = $n['type'] ?? null;
            if ($type === 'text') {
                return htmlspecialchars($n['text'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            }
            $children = '';
            if (isset($n['content']) && is_array($n['content'])) {
                foreach ($n['content'] as $c) {
                    $children .= $map($c);
                }
            }
            switch ($type) {
                case 'paragraph':
                    return '<p>' . $children . '</p>';
                case 'heading':
                    $level = $n['attrs']['level'] ?? 2;
                    $level = is_int($level) ? max(1, min(6, $level)) : 2;
                    return "<h{$level}>" . $children . "</h{$level}>";
                case 'blockquote':
                    return '<blockquote>' . $children . '</blockquote>';
                case 'bulletList':
                    return '<ul>' . $children . '</ul>';
                case 'orderedList':
                    return '<ol>' . $children . '</ol>';
                case 'listItem':
                    return '<li>' . $children . '</li>';
                case 'doc':
                    return $children;
                default:
                    return $children;
            }
        };

        return $map($node);
    }
}
