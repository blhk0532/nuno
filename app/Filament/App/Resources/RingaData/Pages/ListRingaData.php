<?php

namespace App\Filament\App\Resources\RingaData\Pages;

use App\Models\RingaData;
use App\Filament\App\Resources\RingaData\RingaDataResource;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataStatsWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataDisplayWidget;
use App\Filament\App\Resources\RingaData\Widgets\RingaDataOutcomeWidget;
use AymanAlhattami\FilamentContextMenu\Actions\{ RefreshAction, GoBackAction, GoForwardAction};
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
// use Filament\Actions;
use Filament\Support\Enums\Width;
use Filament\Actions\Action;
use App\Filament\Resources\UserResource\Pages\TrashedUsers;
use AymanAlhattami\FilamentContextMenu\ContextMenuDivider;
use AymanAlhattami\FilamentContextMenu\Traits\PageHasContextMenu;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Shreejan\ActionableColumn\Tables\Columns\ActionableColumn;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;

class ListRingaData extends ListRecords
{

 //  use PageHasContextMenu;
    protected static string $resource = RingaDataResource::class;

    public ?int $selectedRecordId = null;

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
