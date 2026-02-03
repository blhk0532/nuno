<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Schemas;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class RingaOutcomeViewForm
{
    public static function configure(Schema $schema, $component = null): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
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
                                        ->extraAttributes([
                                            'class' => 'outcome-button',
                                        ])
                                        ->color($outcome->getColor())
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

                                                // Redirect to the queue page to load the next record
                                                $this->redirect(\App\Filament\App\Resources\RingaDatas\RingaDatasResource::getUrl('queue'));
                                            }
                                        });
                                }, \App\Enums\Outcomes1::cases()),
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

                                                // Redirect to the queue page to load the next record
                                                $this->redirect(\App\Filament\App\Resources\RingaDatas\RingaDatasResource::getUrl('queue'));
                                            }
                                        });
                                }, \App\Enums\Outcomes2::cases()),
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

                                                // Redirect to the queue page to load the next record
                                                $this->redirect(\App\Filament\App\Resources\RingaDatas\RingaDatasResource::getUrl('queue'));
                                            }
                                        });
                                }, \App\Enums\Outcomes4::cases()),
                            ]),
                    ]),
            ]);
    }
}
