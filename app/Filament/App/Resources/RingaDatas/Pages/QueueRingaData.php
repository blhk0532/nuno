<?php

namespace App\Filament\App\Resources\RingaDatas\Pages;

use App\Filament\App\Resources\RingaDatas\RingaDatasResource;
use Filament\Resources\Pages\Page;
use App\Models\RingaData;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataPinpointWidget;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataDisplayWidget;
use Filament\Support\Enums\Width;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataStatsWidget;
use Livewire\Attributes\On;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataOutcomeWidget;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataOutcomeFormWidget;
use App\Filament\App\Resources\Bookings\Widgets\BookingCalendar;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataCalendar;
use Wallacemartinss\FilamentIconPicker\Enums\Remix;
use Wallacemartinss\FilamentIconPicker\Enums\Heroicons;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;
use BackedEnum;
use UnitEnum;

class QueueRingaData extends Page
{
    protected static string $resource = RingaDatasResource::class;

    protected static ?string $slug = 'queue';

    protected static ?string $model = RingaData::class;

    protected static ?string $navigationLabel = 'Ringlista';

    protected static ?string $title = 'Ringlista';

    public ?int $selectedRecordId = null;

   // public static bool $shouldRegisterNavigation = true;

     protected static UnitEnum|string|null $navigationGroup = ' ';

     protected static ?int $navigationSort = 8;

      protected static ?int $sort = 8;

   protected static string|BackedEnum|null $navigationIcon = Tabler::PhoneRinging;

  // protected static string|BackedEnum|null $navigationIcon = Heroicons::OutlinedQueueList;
  // protected static string|BackedEnum|null $activeNavigationIcon = Heroicons::SolidQueueList;


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

        public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getNavigationBadge(): ?string
    {
        $modelClass = self::$model;

        return (string) $modelClass::count();
    }
}
