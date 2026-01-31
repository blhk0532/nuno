<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaData\Pages;

use App\Filament\App\Resources\RingaData\RingaDataResource;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataDisplayWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataOutcomeWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataStatsWidget;
use App\Models\RingaData;
use Asmit\ResizedColumn\HasResizableColumn;
use AymanAlhattami\FilamentContextMenu\Actions\GoBackAction;
use AymanAlhattami\FilamentContextMenu\Actions\GoForwardAction;
use AymanAlhattami\FilamentContextMenu\Actions\RefreshAction;
// use Filament\Actions;
use AymanAlhattami\FilamentContextMenu\ContextMenuDivider;
use AymanAlhattami\FilamentContextMenu\Traits\PageHasContextMenu;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

final class ListRingaData extends ListRecords
{
    //  use PageHasContextMenu;

    use HasResizableColumn;

    public ?int $selectedRecordId = null;

    protected static string $resource = RingaDataResource::class;

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
            Action::make('Create user')
                ->url(CreateRingaData::getUrl()),
            ContextMenuDivider::make(),
            Action::make('Trashed user')
                ->url(QueueRingaData::getUrl()),
        ];

    }

    //  public static function getContextMenuActions(): array
    //  {
    //      return [
    //          RefreshAction::make(),
    //          GoBackAction::make(),
    //          GoForwardAction::make()
    //      ];
    //  }

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
