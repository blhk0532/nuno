<?php

namespace App\Filament\App\Resources\RingaListan\Pages;

use App\Models\RingaData;
use App\Filament\App\Resources\RingaListan\RingaListanResource;
use App\Filament\App\Resources\RingaListan\Widgets\RingaDataStatsWidget;
use App\Filament\App\Resources\RingaListan\Widgets\RingaDataDisplayWidget;
use App\Filament\App\Resources\RingaListan\Widgets\RingaDataOutcomeWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Support\Enums\Width;

class ListRingaData extends ListRecords
{
    protected static string $resource = RingaListanResource::class;

    public ?int $selectedRecordId = null;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
    //    RingaDataPinpointWidget::class,
    //    RingaDataDisplayWidget::class,
    //    RingaDataOutcomeWidget::class,
   // RingaDataStatsWidget::class,

        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 3;
    }

    protected function getHeaderWidgetsData(): array
    {
        return [
            'record' => $this->selectedRecordId ? RingaData::find($this->selectedRecordId) : null,
        ];
    }

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
