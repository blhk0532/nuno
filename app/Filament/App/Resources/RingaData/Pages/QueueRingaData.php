<?php

namespace App\Filament\App\Resources\RingaData\Pages;

use App\Filament\App\Resources\RingaData\RingaDataResource;
use Filament\Resources\Pages\Page;
use App\Models\RingaData;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataPinpointWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataDisplayWidget;
use Filament\Support\Enums\Width;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataOutcomeFormWidget;
use Livewire\Attributes\On;

class QueueRingaData extends Page
{
    protected static string $resource = RingaDataResource::class;

    protected static ?string $slug = 'queue';

    public ?int $selectedRecordId = null;

    protected string $view = 'filament.app.resources.ringa-data.pages.queue';

    public function mount(): void
    {
        try {
            if (!$this->selectedRecordId) {
                $first = RingaData::query()
                    ->whereNull('outcome')
                    ->orderBy('id')
                    ->first();

                $this->selectedRecordId = $first?->id;
            }
            
            // Dispatch event to inform widgets of the selected record
            if ($this->selectedRecordId) {
                $this->dispatch('record-selected', recordId: $this->selectedRecordId);
            }
        } catch (\Exception $e) {
            \Log::error('QueueRingaData mount error: ' . $e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RingaDataPinpointWidget::class,
            RingaDataDisplayWidget::class,
            RingaDataOutcomeFormWidget::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 2;
    }

    public function getHeaderWidgetsData(): array
    {
        $record = null;

        if ($this->selectedRecordId) {
            $record = RingaData::find($this->selectedRecordId);
        }

        if (!$record) {
            $record = RingaData::query()
                ->whereNull('outcome')
                ->orderBy('id')
                ->first();

            $this->selectedRecordId = $record?->id;
        }

        return [
            'record' => $record,
        ];
    }

    #[On('record-selected')]
    public function selectRecord(int $recordId): void
    {
        $this->selectedRecordId = $recordId;
        $this->dispatch('record-selected', recordId: $recordId);
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }
}
