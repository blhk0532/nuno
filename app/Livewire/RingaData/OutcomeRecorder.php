<?php

declare(strict_types=1);

namespace App\Livewire\RingaData;

use App\Models\RingaData;
use App\Services\OutcomeDelayService;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

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

    protected array $outcomeColors = [];

    public function returnCallAction(): Action
    {
        $default = $this->defaultReturnCallAt
            ? Carbon::parse($this->defaultReturnCallAt)
            : now()->addHour();

        $color = $this->outcomeColors['RingTillbaka'] ?? '#2563eb';

        return Action::make('returnCall')
            ->label('Ring Tillbaka')
            ->button()
            ->color('gray')
            ->size('sm')
            ->extraAttributes([
                'class' => 'w-full',
                'style' => "background-color: {$color} !important; color: white !important; border-color: {$color} !important;",
            ])
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
            });
    }

    public function bokadAction(): Action
    {
        $color = $this->outcomeColors['Bokad'] ?? '#16a34a';

        return Action::make('bokad')
            ->label('Bokad')
            ->button()
            ->color('gray')
            ->size('sm')
            ->extraAttributes([
                'class' => 'w-full',
                'style' => "background-color: {$color} !important; color: white !important; border-color: {$color} !important;",
            ])
            ->modalHeading('Bokad')
            ->form([
                \Filament\Forms\Components\Textarea::make('notes')
                    ->label('Anteckningar')
                    ->rows(3),
            ])
            ->action(function (array $data): void {
                $this->recordOutcome('Bokad');

                Notification::make()
                    ->title('Bokad')
                    ->success()
                    ->send();
            });
    }

    public function aterkommerAction(): Action
    {
        $default = $this->defaultReturnCallAt
            ? Carbon::parse($this->defaultReturnCallAt)
            : now()->addHour();

        $color = $this->outcomeColors['Aterkommer'] ?? '#6b7280';

        return Action::make('aterkommer')
            ->label('Återkommer')
            ->button()
            ->color('gray')
            ->size('sm')
            ->extraAttributes([
                'class' => 'w-full',
                'style' => "background-color: {$color} !important; color: white !important; border-color: {$color} !important;",
            ])
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
            });
    }

    public function nextGangAction(): Action
    {
        $color = $this->outcomeColors['NyligenGjort'] ?? '#6b7280';

        return Action::make('nextGang')
            ->label('Nästa Gång')
            ->button()
            ->color('gray')
            ->size('sm')
            ->extraAttributes([
                'class' => 'w-full',
                'style' => "background-color: {$color} !important; color: white !important; border-color: {$color} !important;",
            ])
            ->modalHeading('Välj Nästa Gång')
            ->modalSubmitActionLabel('Spara')
            ->modalWidth('md')
            ->form([
                Select::make('outcome_value')
                    ->label('Resultat')
                    ->options(fn () => collect(\App\Enums\Outcomes3::cases())
                        ->mapWithKeys(fn (\App\Enums\Outcomes3 $case) => [$case->name => $case->getLabel()])
                        ->toArray())
                    ->required(),
            ])
            ->action(function (array $data): void {
                $this->recordOutcome($data['outcome_value']);
            });
    }

    public function offertAction(): Action
    {
        $color = $this->outcomeColors['Offert'] ?? '#16a34a';

        return Action::make('offert')
            ->label('Offert')
            ->button()
            ->color('gray')
            ->size('sm')
            ->extraAttributes([
                'class' => 'w-full',
                'style' => "background-color: {$color} !important; color: white !important; border-color: {$color} !important;",
            ])
            ->modalHeading('Skapa Offert')
            ->modalSubmitActionLabel('Spara Offert')
            ->modalWidth('lg')
            ->form([
                TextInput::make('subject')
                    ->label('Ämne')
                    ->placeholder('Offert ämne')
                    ->required(),
                RichEditor::make('message')
                    ->label('Meddelande')
                    ->placeholder('Offert text...')
                    ->required(),
            ])
            ->action(function (array $data): void {
                // TODO: Save offer and send email
                $this->recordOutcome('Offert');
            });
    }

    public function mount(): void
    {
        Log::info('OutcomeRecorder mount', ['recordId' => $this->recordId, 'tenant' => $this->tenant]);

        // Load outcome colors ONCE
        $this->outcomeColors = \App\Models\OutcomeSetting::pluck('color', 'outcome')->toArray();

        $this->loadRecord();

        if (! $this->defaultReturnCallAt) {
            $this->defaultReturnCallAt = now()->addHour()->seconds(0)->format('Y-m-d H:i');
        }

        // Fallback: if no recordId passed, load first unprocessed record
        if (! $this->record && ! $this->recordId) {
            $this->record = RingaData::query()
                ->where('is_active', true)
                ->where('available_at', '<=', now())
                ->whereRaw('retry_count < (
                    SELECT COALESCE(MAX(max_retry_count), 3)
                    FROM outcome_settings
                    WHERE is_active = TRUE
                )')
                ->orderBy('available_at')
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

        $recordId = $this->recordId ?? $this->record?->id;
        $record = $recordId ? RingaData::query()->find($recordId) : null;

        if (! $record) {
            Notification::make()
                ->title('No record selected')
                ->danger()
                ->send();

            return;
        }

        try {
            Log::info('Recording outcome', [
                'recordId' => $record->id,
                'outcome' => $outcomeValue,
                'aterkom_at' => $aterkom_at,
            ]);

            // Find the actual Outcomes enum that matches this enum name or value
            $outcomeEnum = null;

            // First try to match directly against the main Outcomes enum by name or value
            foreach (\App\Enums\Outcomes::cases() as $case) {
                if ($case->name === $outcomeValue || $case->value === $outcomeValue) {
                    $outcomeEnum = $case;
                    break;
                }
            }

            // If not found, try to find it in the display enums
            if (! $outcomeEnum) {
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
            }

            if (! $outcomeEnum) {
                Log::error('Invalid outcome value', ['value' => $outcomeValue]);
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

                DB::transaction(function () use ($outcomeEnum, $scheduledAt, $record) {
                    $attempts = ($record->attempts ?? 0) + 1;

                    RingaData::query()
                        ->whereKey($record->id)
                        ->update([
                            'is_active' => false,
                            'outcome' => $outcomeEnum->value,
                            'aterkom_at' => $scheduledAt,
                            'attempts' => $attempts,
                            'is_outcome' => true,
                        ]);
                });

                // Refresh to confirm save
                $this->record = RingaData::query()->find($record->id);
                $this->recordId = $record->id;
                Log::info('Outcome marked with return date', [
                    'recordId' => $record->id,
                    'outcome' => $outcomeEnum->value,
                    'is_active' => $this->record?->is_active,
                    'aterkom_at' => $this->record?->aterkom_at,
                    'saved' => true,
                ]);

                Notification::make()
                    ->title('Outcome recorded')
                    ->body("Recorded outcome: {$outcomeEnum->getLabel()} with return call scheduled for {$scheduledAt->format('Y-m-d H:i')}")
                    ->success()
                    ->send();

                $this->loadNextRecord();
                $this->redirect(\App\Filament\App\Resources\RingaDatas\RingaDatasResource::getUrl('queue'));

                return;
            }

            // For other outcomes, defer the record to the end of the queue
            DB::transaction(function () use ($outcomeEnum, $record) {
                $attempts = ($record->attempts ?? 0) + 1;
                $retryCount = ($record->retry_count ?? 0) + 1;
                $maxRetryCount = OutcomeDelayService::getMaxRetryCount($outcomeEnum->value);
                $delayMinutes = OutcomeDelayService::getDelay($outcomeEnum->value) ?? 5;
                $isActive = $retryCount < $maxRetryCount;

                RingaData::query()
                    ->whereKey($record->id)
                    ->update([
                        'is_active' => $isActive,
                        'outcome' => $outcomeEnum->value,
                        'attempts' => $attempts,
                        'retry_count' => $retryCount,
                        'available_at' => $isActive ? now()->addMinutes($delayMinutes) : $record->available_at,
                        'is_outcome' => true,
                    ]);
            });

            // Refresh to confirm save
            $this->record = RingaData::query()->find($record->id);
            $this->recordId = $record->id;
            Log::info('Outcome marked', [
                'recordId' => $record->id,
                'outcome' => $outcomeEnum->value,
                'is_active' => $this->record?->is_active,
                'saved' => true,
            ]);

            Notification::make()
                ->title('Outcome recorded')
                ->body("Recorded outcome: {$outcomeEnum->getLabel()}")
                ->success()
                ->send();

            $this->loadNextRecord();
            $this->redirect(\App\Filament\App\Resources\RingaDatas\RingaDatasResource::getUrl('queue'));

        } catch (Exception $e) {
            Log::error('Error recording outcome', [
                'error' => $e->getMessage(),
                'outcome' => $outcomeValue,
                'recordId' => $recordId,
                'trace' => $e->getTraceAsString(),
            ]);
            Notification::make()
                ->title('Error recording outcome')
                ->body('An error occurred while saving the outcome: '.$e->getMessage())
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

    public function getOutcomeButtons()
    {
        return \App\Models\OutcomeSetting::where('is_active', true)
            ->whereNotNull('color')
            ->orderBy('order')
            ->get();
    }

    private function colorToFilament(string $hexColor): string
    {
        // Map hex colors to Filament color names for consistency
        return match ($hexColor) {
            '#dc2626' => 'danger',
            '#2563eb' => 'primary',
            '#f59e0b' => 'warning',
            '#16a34a' => 'success',
            '#6b7280' => 'gray',
            default => 'gray',
        };
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
        $nextRecord = RingaData::query()
            ->where('is_active', true)
            ->where('available_at', '<=', now())
            ->whereRaw('retry_count < (
                SELECT COALESCE(MAX(max_retry_count), 3)
                FROM outcome_settings
                WHERE is_active = TRUE
            )')
            ->orderBy('available_at')
            ->orderBy('id')
            ->first();

        if ($nextRecord) {
            $this->recordId = $nextRecord->id;
            $this->record = $nextRecord;
            Log::info('Loaded next record', ['recordId' => $nextRecord->id]);

            return;
        }

        $this->recordId = null;
        $this->record = null;
        Log::info('No more records available');
    }
}
