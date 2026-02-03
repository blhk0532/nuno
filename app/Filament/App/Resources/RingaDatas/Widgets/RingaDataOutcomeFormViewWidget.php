<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Widgets;

use App\Filament\App\Resources\RingaDatas\Schemas\RingaOutcomeForm;
use App\Models\RingaData;
use App\Services\OutcomeDelayService;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

final class RingaDataOutcomeFormViewWidget extends Widget implements HasSchemas
{
    use InteractsWithSchemas;

    public ?RingaData $record = null;

    protected static ?string $heading = 'Call Outcomes';

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.app.resources.ringa-data.widgets.ringa-data-outcome-form-widget';

    public function mount($record = null): void
    {
        $this->record = $record;
    }

    #[On('record-selected')]
    public function updateRecord(int $recordId): void
    {
        $this->record = RingaData::find($recordId);
    }

    public function handleOutcome($outcome): void
    {
        if ($this->record) {
            $updateData = [
                'outcome' => $outcome,
                'attempts' => ($this->record->attempts ?? 0) + 1,
            ];

            // Check if this outcome has a configured delay
            $delayMinutes = OutcomeDelayService::getDelay($outcome->value);
            if ($delayMinutes !== null) {
                $updateData['available_at'] = now()->addMinutes($delayMinutes);
            }

            $this->record->update($updateData);

            // Redirect to queue page to load next record
            $this->redirect(\App\Filament\App\Resources\RingaDatas\RingaDatasResource::getUrl('queue'));
        }
    }

    public function schema(): Schema
    {
        return RingaOutcomeForm::configure(
            Schema::make($this),
            $this->record
        );
    }
}
