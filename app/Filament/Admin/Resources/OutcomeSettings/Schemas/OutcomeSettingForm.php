<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OutcomeSettings\Schemas;

use App\Enums\Outcomes;
use App\Enums\OutcomeType;
use App\UserRole;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class OutcomeSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Basic Information')
                    ->columns(2)
                    ->components([

                        TextInput::make('outcome')
                            ->label('Outcome')
                            ->placeholder('Outcome identifier')
                            ->helperText('Unique outcome value')
                            ->columnSpan(1),

                        Select::make('type')
                            ->label('Type')
                            ->options(fn () => collect(Outcomes::cases())
                                ->mapWithKeys(fn (Outcomes $case) => [$case->name => $case->getLabel()])
                                ->toArray())
                            ->required()
                            ->helperText('Outcome enum value')
                            ->columnSpan(1),
                        Select::make('category')
                            ->label('Category')
                            ->options(fn () => collect(OutcomeType::cases())
                                ->mapWithKeys(fn (OutcomeType $case) => [$case->value => $case->name])
                                ->toArray())
                            ->helperText('Outcome category')
                            ->columnSpan(1),
                        Select::make('access')
                            ->label('Access')
                            ->options(fn () => ['all' => 'All'] + collect(UserRole::cases())
                                ->mapWithKeys(fn (UserRole $case) => [$case->value => $case->label()])
                                ->toArray())
                            ->helperText('Role-based access')
                            ->columnSpan(1),
                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Display title for buttons')

                            ->columnSpan(1),
                        TextInput::make('description')
                            ->label('Description')
                            ->placeholder('Optional description for this outcome setting')
                            ->helperText('')
                            ->maxLength(500)
                            ->columnSpan(1),
                        ColorPicker::make('color')
                            ->label('Color')
                            ->format('hex')
                       //     ->helperText('Hex color code for the outcome')
                            ->columnSpan(1),

                        TextInput::make('icon')
                            ->label('Icon')
                            ->placeholder('e.g., heroicon-o-check-circle')
                       //     ->helperText('Icon name (e.g., from Heroicons)')
                            ->columnSpan(1),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Is outcome active')
                            ->columnSpan(1),
                        Toggle::make('bokad')
                            ->label('Bokad')
                            ->helperText('Is outcome bokad')
                            ->columnSpan(1),
                    ]),

                Section::make('Retry & Queue Settings')
                    ->columns(2)
                    ->components([

                        TextInput::make('delay_minutes')
                            ->label('Delay (Minutes)')
                            ->numeric()
                            ->placeholder('e.g., 5')
                            ->helperText('Delay in minutes before retry')
                            ->columnSpan(1),

                        TextInput::make('max_retry_count')
                            ->label('Max Retry Count')
                            ->numeric()
                            ->placeholder('e.g., 3')
                            ->helperText('Maximum number of retry attempts')
                            ->columnSpan(1),

                        TextInput::make('order')
                            ->label('Order')
                            ->numeric()
                            ->placeholder('e.g., 1')
                            ->helperText('Order of the outcome setting')
                            ->columnSpan(1),
                        TextInput::make('quarantine_days')
                            ->label('Quarantine Days')
                            ->numeric()
                            ->placeholder('e.g., 7')
                            ->helperText('Days to quarantine after this outcome')
                            ->default(0)
                            ->columnSpan(1),
                        Toggle::make('quarantine')
                            ->label('Quarantine')
                            ->helperText('Enable quarantine for this outcome')
                            ->default(false)
                            ->columnSpan(1),

                        Toggle::make('retry')
                            ->label('Retry')
                            ->helperText('Allow retrying this outcome')
                            ->default(false)
                            ->columnSpan(1),
                        Toggle::make('dmc')
                            ->label('DMC')
                            ->helperText('Block number - DO NEVER CALL AGAIN')
                            ->default(false)
                            ->columnSpan(1),

                        Toggle::make('aterkom')
                            ->label('Återkom')
                            ->helperText('Trigger schedule call-back modal')
                            ->default(false)
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
