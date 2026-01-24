<?php

namespace App\Livewire\RingaData;

use App\Models\RingaData;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\Attributes\Reactive;

class OutcomeRecorder extends Component
{
    #[Reactive]
    public ?int $recordId = null;

    public ?RingaData $record = null;

    public function mount(): void
    {
        \Log::info('OutcomeRecorder mount', ['recordId' => $this->recordId]);
        $this->loadRecord();
    }

    public function updated($property): void
    {
        if ($property === 'recordId') {
            $this->loadRecord();
        }
    }

    private function loadRecord(): void
    {
        if ($this->recordId) {
            $this->record = RingaData::find($this->recordId);
            \Log::info('Loaded record', ['recordId' => $this->recordId, 'found' => (bool)$this->record]);
        } else {
            $this->record = null;
            \Log::info('No recordId provided');
        }
    }

    public function recordOutcome($outcomeValue): void
    {
        if (!$this->record) {
            Notification::make()
                ->title('No record selected')
                ->danger()
                ->send();
            return;
        }

        try {
            // Find the actual Outcomes enum that matches this value
            $outcomeEnum = null;
            
            foreach (\App\Enums\Outcomes::cases() as $case) {
                if ($case->value === $outcomeValue) {
                    $outcomeEnum = $case;
                    break;
                }
            }

            if (!$outcomeEnum) {
                Notification::make()
                    ->title('Invalid outcome value: ' . $outcomeValue)
                    ->danger()
                    ->send();
                return;
            }

            // Update the record
            $this->record->outcome = $outcomeEnum;
            $this->record->attempts = ($this->record->attempts ?? 0) + 1;
            $this->record->save();

            Notification::make()
                ->title('Outcome recorded: ' . $outcomeEnum->getLabel())
                ->success()
                ->send();

            // Redirect to fresh queue page using current tenant
            $tenantSlug = request()->route('tenant');
            if (!$tenantSlug) {
                // Extract tenant from the referrer or current route
                $tenantSlug = request()->header('referer') ? 
                    preg_match('/team\/([a-zA-Z0-9]+)/', request()->header('referer'), $m) ? $m[1] : null : 
                    null;
            }
            
            if ($tenantSlug) {
                $queueUrl = route('filament.app.resources.ringa-data.queue', ['tenant' => $tenantSlug]);
            } else {
                $queueUrl = '/nds/app/team/' . ($tenantSlug ?? 'unknown') . '/ringa-data/queue';
            }
            
            $this->redirect($queueUrl);
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.ringa-data.outcome-recorder');
    }
}
