<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeDelaySettings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class OutcomeDelaySettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('outcome')
                    ->label('Outcome Name')
                    ->placeholder('e.g., EjFramkopplad, Upptagen, Voicemail, IngetSvar')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->readOnlyOn('edit'),
                TextInput::make('delay_minutes')
                    ->label('Delay (Minutes)')
                    ->numeric()
                    ->minValue(0)
                    ->required()
                    ->helperText('Number of minutes to delay the available_at timestamp'),
                TextInput::make('max_retry_count')
                    ->label('Max Retry Count')
                    ->numeric()
                    ->minValue(1)
                    ->default(3)
                    ->required()
                    ->helperText('Maximum number of times a record can be retried for this outcome'),
                Textarea::make('description')
                    ->label('Description')
                    ->placeholder('Optional description for this outcome delay setting')
                    ->maxLength(500),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Enable or disable this outcome delay setting'),
            ]);
    }
}
