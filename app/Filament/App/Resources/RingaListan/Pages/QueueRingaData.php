<?php

namespace App\Filament\App\Resources\RingaListan\Pages;

use App\Filament\App\Resources\RingaListan\RingaListanResource;
use Filament\Resources\Pages\Page;
use App\Models\RingaData;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\App\Resources\RingaListan\Widgets\RingaDataPinpointWidget;
use App\Filament\App\Resources\RingaListan\Widgets\RingaDataDisplayWidget;
use Filament\Support\Enums\Width;
use App\Filament\App\Resources\RingaListan\Widgets\RingaDataStatsWidget;
use Livewire\Attributes\On;
use App\Filament\App\Resources\RingaListan\Widgets\RingaDataOutcomeWidget;
use App\Filament\App\Resources\RingaListan\Widgets\RingaDataOutcomeFormWidget;
use App\Filament\App\Resources\Bookings\Widgets\BookingCalendar;
use App\Filament\App\Resources\RingaListan\Widgets\RingaDataCalendar;
use App\Filament\App\Resources\RingaListan\Widgets\RingaDataTableWidget;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;
use Wallacemartinss\FilamentIconPicker\Enums\Heroicons;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;
use BackedEnum;
use UnitEnum;

class QueueRingaData extends Page
{
    protected static string $resource = RingaListanResource::class;

    protected static ?string $slug = 'queues';

    protected static ?string $model = RingaData::class;

    protected static ?string $navigationLabel = 'Ringlista';

    protected static ?string $title = 'Ringlista';

    public ?int $selectedRecordId = null;

   // public static bool $shouldRegisterNavigation = true;

   //  protected static UnitEnum|string|null $navigationGroup = '';

     protected static ?int $navigationSort = 2;

   protected static string|BackedEnum|null $navigationIcon = Tabler::PhoneRinging;

  // protected static string|BackedEnum|null $navigationIcon = Heroicons::OutlinedQueueList;
  // protected static string|BackedEnum|null $activeNavigationIcon = Heroicons::SolidQueueList;

    public static function getNavigationBadge(): ?string
    {
        return static::getResource()::getEloquentQuery()
            ->whereNull('outcome')
            ->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    protected string $view = 'filament.app.resources.ringa-data.pages.queue';

    protected function getQuery(): Builder
    {
        return static::getResource()::getEloquentQuery()
            ->where(function (Builder $query) {
                $query->whereNull('outcome');
                //    ->orWhere('attempts', '<', 3);
            });
    }

    public function mount(): void
    {
        try {
            if (!$this->selectedRecordId) {
                $first = $this->getQuery()
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

            RingaDataTableWidget::class,

            RingaDataCalendar::class,
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
            $record = $this->getQuery()->find($this->selectedRecordId);
        }

        if (!$record) {
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
}
