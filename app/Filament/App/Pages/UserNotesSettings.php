<?php

declare(strict_types=1);

namespace App\Filament\App\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Inerba\DbConfig\AbstractPageSettings;

final class UserNotesSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    // Match parent property signature to avoid PHP fatal type mismatch
    protected static BackedEnum|string|null $navigationIcon = null;

    protected static ?string $title = 'User Notes';

    // protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver'; // Uncomment if you want to set a custom navigation icon

    // protected ?string $subheading = ''; // Uncomment if you want to set a custom subheading

    // protected static ?string $slug = 'user-notes-settings'; // Uncomment if you want to set a custom slug

    protected string $view = 'filament.pages.user-notes-settings';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    /**
     * Provide default values.
     *
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        return [];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                RichEditor::make('anteckningar')
                    ->label('Mina Anteckningar!')
                    ->columnSpan('full'),
                Action::make('save')
                    ->action(function () {
                        $this->save();
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Saved')
                            ->send();
                    })
                    ->label('Save'),
            ])
            ->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->action(function () {
                    $this->save();
                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Saved')
                        ->send();
                })
                ->label('Save'),
        ];
    }

    protected function settingName(): string
    {
        $userId = Auth::id() ?? 'guest';

        return "user_notes_{$userId}";
    }
}
