<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaData\Schemas;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class RingaOutcomeForm
{
    public static function configure(Schema $schema, $record = null, $component = null): Schema
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
                                ...array_map(function ($outcome) use ($component) {
                                    return Action::make("outcome_{$outcome->value}")
                                        ->label($outcome->getLabel())
                                        ->extraAttributes([
                                            'class' => 'outcome-button',
                                        ])
                                        ->color($outcome->getColor())
                                        ->action(function ($record) use ($outcome, $component) {
                                            if ($record) {
                                                $record->update([
                                                    'outcome' => $outcome->value,
                                                    'is_outcome' => true,
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
                                                if ($component && method_exists($component, 'redirect')) {
                                                    $component->redirect(\App\Filament\App\Resources\RingaData\RingaDataResource::getUrl('queue'));
                                                }
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
                                ...array_map(function ($outcome) use ($component) {
                                    return Action::make("outcome_{$outcome->value}")
                                        ->label($outcome->getLabel())
                                        ->color($outcome->getColor())
                                        ->extraAttributes([
                                            'class' => 'outcome-button',
                                        ])
                                        ->action(function ($record) use ($outcome, $component) {
                                            if ($record) {
                                                $record->update([
                                                    'outcome' => $outcome->value,
                                                    'is_outcome' => true,
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
                                                if ($component && method_exists($component, 'redirect')) {
                                                    $component->redirect(\App\Filament\App\Resources\RingaData\RingaDataResource::getUrl('queue'));
                                                }
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
                                ...array_map(function ($outcome) use ($component) {
                                    return Action::make("outcome_{$outcome->value}")
                                        ->label($outcome->getLabel())
                                        ->color($outcome->getColor())
                                        ->extraAttributes([
                                            'class' => 'outcome-button',
                                        ])
                                        ->action(function ($record) use ($outcome, $component) {
                                            if ($record) {
                                                $record->update([
                                                    'outcome' => $outcome->value,
                                                    'is_outcome' => true,
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
                                                if ($component && method_exists($component, 'redirect')) {
                                                    $component->redirect(\App\Filament\App\Resources\RingaData\RingaDataResource::getUrl('queue'));
                                                }
                                            }
                                        });
                                }, \App\Enums\Outcomes4::cases()),
                            ]),
                    ]),
            ]);
    }
}
