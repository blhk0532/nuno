<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaData\Pages;

use App\Filament\App\Resources\RingaData\RingaDataResource;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataCalendar;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataDisplayWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataOutcomeFormWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataOutcomeWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataPinpointWidget;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDatasQueueTableWidget;
use Exception;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

final class QueueRingaData extends Page
{
    public ?int $selectedRecordId = null;

    protected static string $resource = RingaDataResource::class;

    protected static ?string $slug = 'qued';

    protected string $view = 'filament.app.resources.ringa-data.pages.queue';

    public function mount(): void
    {
        try {
            if (! $this->selectedRecordId) {
                $first = $this->getQuery()
                    ->orderBy('id')
                    ->first();

                $this->selectedRecordId = $first?->id;
            }

            // Dispatch event to inform widgets of the selected record
            if ($this->selectedRecordId) {
                $this->dispatch('record-selected', recordId: $this->selectedRecordId);
            }
        } catch (Exception $e) {
            logger('QueueRingaData mount error: '.$e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 2;
    }

    public function getHeaderWidgetsData(): array
    {
        $record = null;

        if ($this->selectedRecordId) {
            $record = $this->getQuery()->find($this->selectedRecordId);
        }

        if (! $record) {
            $record = $this->getQuery()
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

    protected function getQuery(): Builder
    {
        return self::getResource()::getEloquentQuery()
            ->where(function (Builder $query) {
                $query->whereNull('outcome');
                //    ->orWhere('attempts', '<', 3);
            });
    }

    protected function getHeaderWidgets(): array
    {
        return [

            //    RingaDataPinpointWidget::class,
            //    RingaDataDisplayWidget::class,
            //    RingaDataOutcomeFormWidget::class,
            //    RingaDataOutcomeWidget::class,
            //    RingaDataCalendar::class,
            //    RingaDatasQueueTableWidget::class,
        ];
    }
}
