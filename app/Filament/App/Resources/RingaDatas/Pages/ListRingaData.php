<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Pages;

use App\Filament\App\Resources\RingaDatas\RingaDatasResource;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataDisplayWidget;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataOutcomeWidget;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataStatsWidget;
use App\Models\RingaData;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

final class ListRingaData extends ListRecords
{
    public ?int $selectedRecordId = null;

    protected static string $resource = RingaDatasResource::class;

    public function getHeaderWidgetsColumns(): int|array
    {
        return 3;
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
            RingaDataStatsWidget::class,

        ];
    }

    protected function getHeaderWidgetsData(): array
    {
        return [
            'record' => $this->selectedRecordId ? RingaData::find($this->selectedRecordId) : null,
        ];
    }
}
