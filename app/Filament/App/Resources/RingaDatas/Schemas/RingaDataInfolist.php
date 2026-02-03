<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

final class RingaDataInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                RichEditor::make('user_notes')
                    ->label('Anteckningar')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                        ['table', 'attachFiles'], // The `customBlocks` and `mergeTags` tools are also added here if those features are used.
                        ['undo', 'redo'],
                    ]),
            ]);
    }
}
