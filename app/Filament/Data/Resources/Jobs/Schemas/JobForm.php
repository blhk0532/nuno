<?php

declare(strict_types=1);

namespace App\Filament\Data\Resources\Jobs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class JobForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('queue')
                    ->required(),
                Textarea::make('payload')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('attempts')
                    ->required()
                    ->numeric(),
                TextInput::make('reserved_at')
                    ->numeric(),
                TextInput::make('available_at')
                    ->required()
                    ->numeric(),
            ]);
    }
}
