<?php

declare(strict_types=1);

namespace App\Livewire\RingaData;

use App\Models\RingaData;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Log;

final class OutcomeRecorder extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?int $recordId = null;

    public ?RingaData $record = null;

    public ?string $tenant = null;

    protected $listeners = [
        'externalRecordOutcome' => 'recordOutcome',
    ];

    protected ?string $defaultReturnCallAt = null;

    public function returnCallAction(): Action
    {
        $default = $this->defaultReturnCallAt
            ? Carbon::parse($this->defaultReturnCallAt)
            : now()->addHour();

        $outcome = \App\Enums\Outcomes4::RingTillbaka;

        return $this->cacheAction(
            Action::make('returnCall')
                ->label('Ring Tillbaka')
                ->color($outcome->getColor())
                ->button()
                ->size('sm')
                ->extraAttributes(['class' => 'w-full'])
                ->modalHeading('Schemalägg återkommande samtal')
                ->modalSubmitActionLabel('Schemalägg')
                ->modalWidth('md')
                ->form([
                    DateTimePicker::make('aterkom_at')
                        ->label('Datum och tid för återkommande samtal')
                        ->default(fn () => $default)
                        ->native(false)
                        ->seconds(false)
                        ->timezone(config('app.timezone'))
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $this->recordOutcome('RingTillbaka', $data['aterkom_at'] ?? null);
                })
        );
    }

    public function aterkommerAction(): Action
    {
        $default = $this->defaultReturnCallAt
            ? Carbon::parse($this->defaultReturnCallAt)
            : now()->addHour();

        $outcome = \App\Enums\Outcomes4::Aterkommer;

        return $this->cacheAction(
            Action::make('aterkommer')
                ->label('Återkommer')
                ->color($outcome->getColor())
                ->button()
                ->size('sm')
                ->extraAttributes(['class' => 'w-full'])
                ->modalHeading('Schemalägg återkommande samtal')
                ->modalSubmitActionLabel('Schemalägg')
                ->modalWidth('md')
                ->form([
                    DateTimePicker::make('aterkom_at')
                        ->label('Datum och tid för återkommande samtal')
                        ->default(fn () => $default)
                        ->native(false)
                        ->seconds(false)
                        ->timezone(config('app.timezone'))
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $this->recordOutcome('Aterkommer', $data['aterkom_at'] ?? null);
                })
        );
    }

    public function mount(): void
    {
        Log::info('OutcomeRecorder mount', ['recordId' => $this->recordId, 'tenant' => $this->tenant]);

        $this->loadRecord();

        if (! $this->defaultReturnCallAt) {
            $this->defaultReturnCallAt = now()->addHour()->seconds(0)->format('Y-m-d H:i');
        }

        // Fallback: if no recordId passed, load first unprocessed record
        if (! $this->record && ! $this->recordId) {
            $this->record = RingaData::where('is_active', true)
                ->orderBy('id')
                ->first();
            if ($this->record) {
                $this->recordId = $this->record->id;
                Log::info('Loaded fallback record', ['recordId' => $this->recordId]);
            }
        }
    }

    public function updated($property): void
    {
        if ($property === 'recordId') {
            $this->loadRecord();
        }
    }

    public function recordOutcome($outcomeValue, $aterkom_at = null): void
    {
        if (empty($outcomeValue)) {
            Log::error('recordOutcome called with empty value');
            Notification::make()
                ->title('Invalid outcome value')
                ->body('Empty outcome value received')
                ->danger()
                ->send();

            return;
        }

        if (! $this->record) {
            Notification::make()
                ->title('No record selected')
                ->danger()
                ->send();

            return;
        }

        try {
            Log::info('Recording outcome', [
                'recordId' => $this->record->id,
                'outcome' => $outcomeValue,
                'aterkom_at' => $aterkom_at,
            ]);

            // Find the actual Outcomes enum that matches this enum name
            $outcomeEnum = null;

            // First try to find it in the display enums
            $displayEnums = [
                \App\Enums\Outcomes1::class,
                \App\Enums\Outcomes2::class,
                \App\Enums\Outcomes4::class,
            ];

            foreach ($displayEnums as $enumClass) {
                try {
                    // Find the enum case by name
                    $displayEnum = null;
                    foreach ($enumClass::cases() as $case) {
                        if ($case->name === $outcomeValue) {
                            $displayEnum = $case;
                            break;
                        }
                    }

                    if ($displayEnum) {
                        // Find the corresponding main enum by value
                        foreach (\App\Enums\Outcomes::cases() as $case) {
                            if ($case->value === $displayEnum->value) {
                                $outcomeEnum = $case;
                                break 2;
                            }
                        }

                        // Fallback: match by name
                        foreach (\App\Enums\Outcomes::cases() as $case) {
                            if ($case->name === $displayEnum->name) {
                                $outcomeEnum = $case;
                                break 2;
                            }
                        }
                    }
                } catch (Exception $e) {
                    // Not in this enum, continue
                }
            }

            if (! $outcomeEnum) {
                Notification::make()
                    ->title('Invalid outcome value: '.$outcomeValue)
                    ->danger()
                    ->send();

                return;
            }

            // If outcome is "Ring Tillbaka" or "Återkommer" we expect a scheduled datetime from the action form
            if (in_array($outcomeEnum->value, ['Ring Tillbaka', 'Återkommer'])) {
                if (blank($aterkom_at)) {
                    Notification::make()
                        ->title('Datum och tid krävs')
                        ->body('Välj ett datum och en tid för återkommande samtal.')
                        ->danger()
                        ->send();

                    return;
                }

                $scheduledAt = Carbon::parse($aterkom_at);

                $this->record->is_active = false;
                $this->record->aterkom_at = $scheduledAt;
                $this->record->attempts = ($this->record->attempts ?? 0) + 1;
                $this->record->save();

                // Refresh to confirm save
                $this->record->refresh();
                Log::info('Outcome marked with return date', [
                    'recordId' => $this->record->id,
                    'is_active' => $this->record->is_active,
                    'aterkom_at' => $this->record->aterkom_at,
                ]);

                Notification::make()
                    ->title('Outcome recorded')
                    ->body("Recorded outcome: {$outcomeEnum->getLabel()} with return call scheduled for {$scheduledAt->format('Y-m-d H:i')}")
                    ->success()
                    ->send();

                $this->loadNextRecord();

                return;
            }

            // For other outcomes, just save
            $this->record->is_active = false;
            $this->record->attempts = ($this->record->attempts ?? 0) + 1;
            $this->record->save();

            // Refresh to confirm save
            $this->record->refresh();
            Log::info('Outcome marked', [
                'recordId' => $this->record->id,
                'is_active' => $this->record->is_active,
            ]);

            Notification::make()
                ->title('Outcome recorded')
                ->body("Recorded outcome: {$outcomeEnum->getLabel()}")
                ->success()
                ->send();

            $this->loadNextRecord();

        } catch (Exception $e) {
            Log::error('Error recording outcome', ['error' => $e->getMessage(), 'outcome' => $outcomeValue]);
            Notification::make()
                ->title('Error recording outcome')
                ->body('An error occurred while saving the outcome')
                ->danger()
                ->send();
        }
    }

    public function getColorClass($colorName): string
    {
        return match ($colorName) {
            'danger' => 'bg-red-600 hover:bg-red-700',
            'success' => 'bg-green-600 hover:bg-green-700',
            'warning' => 'bg-amber-600 hover:bg-amber-700',
            'primary' => 'bg-blue-600 hover:bg-blue-700',
            'secondary' => 'bg-gray-600 hover:bg-gray-700',
            'gray' => 'bg-slate-600 hover:bg-slate-700',
            default => 'bg-blue-600 hover:bg-blue-700',
        };
    }

    public function render()
    {
        return view('livewire.ringa-data.outcome-recorder');
    }

    private function loadRecord(): void
    {
        if ($this->recordId) {
            $this->record = RingaData::find($this->recordId);
            Log::info('Loaded record', ['recordId' => $this->recordId, 'found' => (bool) $this->record]);
        } else {
            $this->record = null;
            Log::info('No recordId provided');
        }
    }

    private function loadNextRecord(): void
    {
        // Full page reload to refresh all widgets
        $this->js('window.location.reload()');
    }
}
