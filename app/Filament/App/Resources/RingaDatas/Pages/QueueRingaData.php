<?php

namespace App\Filament\App\Resources\RingaDatas\Pages;

use App\Filament\App\Resources\RingaDatas\RingaDatasResource;
use Filament\Resources\Pages\Page;
use App\Models\RingaData;
use Illuminate\Database\Eloquent\Builder;
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
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDatasQueueTableWidget;
use BackedEnum;
use UnitEnum;
use Filament\Notifications\Notification;

class QueueRingaData extends Page
{
    protected static string $resource = RingaDatasResource::class;

    protected static ?string $slug = 'queue';

    protected static ?string $model = RingaData::class;

    protected static ?string $navigationLabel = 'Ringlistan';

    protected static ?string $title = 'Ringlistan';

    public ?int $selectedRecordId = null;

   // public static bool $shouldRegisterNavigation = true;

     protected static UnitEnum|string|null $navigationGroup = ' ';

     protected static ?int $navigationSort = 8;

      protected static ?int $sort = 8;

   protected static string|BackedEnum|null $navigationIcon = Tabler::PhoneRinging;

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
            // Check if there are any pending records
            $pendingCount = $this->getQuery()->count();

            if ($pendingCount === 0) {
                // Get the current tenant
                $tenant = filament()->getTenant();

                // Redirect to dashboard if no pending records
                $this->redirect(route('filament.app.pages.app-dashboard', ['tenant' => $tenant]), navigate: true);
            }

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
