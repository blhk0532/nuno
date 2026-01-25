<?php

namespace App\Filament\App\Resources\RingaData\Pages;

use App\Filament\App\Resources\RingaData\RingaDataResource;
use Filament\Resources\Pages\Page;
use App\Models\RingaData;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataPinpointWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataDisplayWidget;
use Filament\Support\Enums\Width;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataStatsWidget;
use Livewire\Attributes\On;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataOutcomeWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataOutcomeFormWidget;
use App\Filament\App\Resources\Bookings\Widgets\BookingCalendar;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataCalendar;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDatasQueueTableWidget;

class QueueRingaData extends Page
{
    protected static string $resource = RingaDataResource::class;

    protected static ?string $slug = 'qued';

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
            logger('QueueRingaData mount error: ' . $e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }

    protected function getHeaderWidgets(): array
    {
        return [

            RingaDataPinpointWidget::class,
            RingaDataDisplayWidget::class,
                 RingaDataOutcomeFormWidget::class,
            RingaDataOutcomeWidget::class,

            RingaDataCalendar::class,
            RingaDatasQueueTableWidget::class,
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
            'recordId' => $this->selectedRecordId,
        ];
    }

    public function selectRecord(int $recordId): void
    {
        $this->selectedRecordId = $recordId;
        $this->dispatch('record-selected', recordId: $recordId);
    }

    #[On('record-selected')]
    public function handleRecordSelected(int $recordId): void
    {
        $this->selectedRecordId = $recordId;
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }
}
