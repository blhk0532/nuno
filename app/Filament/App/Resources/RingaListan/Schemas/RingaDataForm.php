<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaListan\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class RingaDataForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                RichEditor::make('user_notes')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                        ['table', 'attachFiles', 'customBlocks', 'mergeTags'],
                        ['undo', 'redo'],
                    ]),
                Section::make()
                    ->description('')
                    ->label('')
                    ->extraAttributes([
                        'class' => 'outcome-buttons-section',
                    ])
                    ->schema([
                        // We'll add the outcome buttons as actions instead
                    ])
                    ->compact()
                    ->headerActions([
                        ...array_map(function ($outcome) {
                            return Action::make("outcome_{$outcome->value}")
                                ->label($outcome->getLabel())
                                ->icon($outcome->getIcon())
                                ->color($outcome->getColor())
                                ->extraAttributes([
                                    'class' => 'outcome-button',
                                ])
                                ->action(function ($record) use ($outcome) {
                                    if ($record) {
                                        $record->update([
                                            'outcome' => $outcome,
                                            'attempts' => ($record->attempts ?? 0) + 1,
                                        ]);

                                        Notification::make()
                                            ->title('Outcome recorded')
                                            ->body("Recorded outcome: {$outcome->getLabel()}")
                                            ->icon($outcome->getIcon())
                                            ->color($outcome->getColor())
                                            ->success()
                                            ->send();
                                    }
                                });
                        }, \App\Enums\Outcomes::cases()),
                    ]),
                Textarea::make('gatuadress')
                    ->columnSpanFull(),
                Textarea::make('postnummer')
                    ->columnSpanFull(),
                Textarea::make('postort')
                    ->columnSpanFull(),
                Textarea::make('forsamling')
                    ->columnSpanFull(),
                Textarea::make('kommun')
                    ->columnSpanFull(),
                Textarea::make('kommun_ratsit')
                    ->columnSpanFull(),
                Textarea::make('lan')
                    ->columnSpanFull(),
                Textarea::make('adressandring')
                    ->columnSpanFull(),
                TextInput::make('telfonnummer')
                    ->tel(),
                Textarea::make('stjarntacken')
                    ->columnSpanFull(),
                Textarea::make('fodelsedag')
                    ->columnSpanFull(),
                Textarea::make('personnummer')
                    ->columnSpanFull(),
                Textarea::make('alder')
                    ->columnSpanFull(),
                Textarea::make('kon')
                    ->columnSpanFull(),
                Textarea::make('civilstand')
                    ->columnSpanFull(),
                Textarea::make('fornamn')
                    ->columnSpanFull(),
                Textarea::make('efternamn')
                    ->columnSpanFull(),
                Textarea::make('personnamn')
                    ->columnSpanFull(),
                Textarea::make('telefon')
                    ->columnSpanFull(),
                TextInput::make('epost_adress'),
                Textarea::make('agandeform')
                    ->columnSpanFull(),
                Textarea::make('bostadstyp')
                    ->columnSpanFull(),
                Textarea::make('boarea')
                    ->columnSpanFull(),
                Textarea::make('byggar')
                    ->columnSpanFull(),
                Textarea::make('fastighet')
                    ->columnSpanFull(),
                TextInput::make('personer'),
                TextInput::make('foretag'),
                TextInput::make('grannar'),
                TextInput::make('fordon'),
                TextInput::make('hundar'),
                TextInput::make('bolagsengagemang'),
                Textarea::make('longitude')
                    ->columnSpanFull(),
                Textarea::make('latitud')
                    ->columnSpanFull(),
                Textarea::make('google_maps')
                    ->columnSpanFull(),
                Textarea::make('google_streetview')
                    ->columnSpanFull(),
                Textarea::make('ratsit_se')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_hus')
                    ->required(),
                Toggle::make('is_telefon')
                    ->required(),
                Toggle::make('is_queued')
                    ->required(),
                TextInput::make('status'),
                TextInput::make('attempts')
                    ->numeric()
                    ->default(0),
                TextInput::make('booking_id')
                    ->numeric(),
                TextInput::make('calendar_id')
                    ->numeric(),
                DateTimePicker::make('booked_at')
                    ->native(true),
                Textarea::make('user_id')
                    ->columnSpanFull(),
                Textarea::make('service_user_id')
                    ->columnSpanFull(),
                DateTimePicker::make('started_at')
                    ->required()
                    ->native(true),
                DateTimePicker::make('expires_at')
                    ->required()
                    ->native(true),
            ]);
    }
}
