<?php

declare(strict_types=1);

namespace App\Filament\App\Pages;

use BackedEnum;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Inerba\DbConfig\AbstractPageSettings;

final class ManuSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected static ?string $title = 'Manu';

    // protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver'; // Uncomment if you want to set a custom navigation icon

    // protected ?string $subheading = ''; // Uncomment if you want to set a custom subheading

    // protected static ?string $slug = 'manus-settings'; // Uncomment if you want to set a custom slug

    protected string $view = 'filament.pages.manus-settings';

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

                RichEditor::make('site_name')
                    ->label('Anteckningar')
                    ->columnSpan('full'),
            ])
            ->statePath('data');
    }

    protected function settingName(): string
    {
        return 'manus';
    }
}
