<?php

namespace App\Filament\App\Resources\RingaData\Widgets;

use App\Models\RingaData;
use App\Filament\App\Resources\RingaData\Schemas\RingaOutcomeForm;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class RingaDataOutcomeFormViewWidget extends Widget implements HasSchemas
{
    use InteractsWithSchemas;

    protected static ?string $heading = 'Call Outcomes';

    protected int | string | array $columnSpan = 'full';

    protected string $view = 'filament.app.resources.ringa-data.widgets.ringa-data-outcome-form-widget';

    public ?RingaData $record = null;

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
            $this->record->update([
                'outcome' => $outcome,
                'attempts' => ($this->record->attempts ?? 0) + 1,
            ]);

            // Redirect to queue page to load next record
            $this->redirect(\App\Filament\App\Resources\RingaData\RingaDataResource::getUrl('queue'));
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
