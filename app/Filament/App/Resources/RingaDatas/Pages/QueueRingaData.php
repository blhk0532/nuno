<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Pages;

use App\Filament\App\Resources\RingaDatas\RingaDatasResource;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataCalendar;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataDisplayWidget;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataOutcomeFormWidget;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataOutcomeWidget;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDataPinpointWidget;
use App\Filament\App\Resources\RingaDatas\Widgets\RingaDatasQueueTableWidget;
use App\Models\RingaData;
use BackedEnum;
use Exception;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use UnitEnum;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;

final class QueueRingaData extends Page
{
    public ?int $selectedRecordId = null;

    protected static string $resource = RingaDatasResource::class;

    protected static ?string $slug = 'queue';

    protected static ?string $model = RingaData::class;

    protected static ?string $navigationLabel = 'Ringlista';

    protected static ?string $title = 'Ringlista';

    // public static bool $shouldRegisterNavigation = true;

    protected static UnitEnum|string|null $navigationGroup = '';

    protected static ?int $navigationSort = 4;

    protected static ?int $sort = 4;

    protected static string|BackedEnum|null $navigationIcon = Tabler::PhoneRinging;

    protected string $view = 'filament.app.resources.ringa-data.pages.queue';

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return true;
    }

    public static function getNavigationBadge(): ?string
    {
        $count = self::getResource()::getEloquentQuery()
            ->whereNotNull('outcome')
            ->where('outcome', false)
            ->where('user_id', Auth::id())
        //    ->whereDate('updated_at', today())
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public function mount(): void
    {
        try {
            // Always reset selectedRecordId on mount to avoid stale state
            $this->selectedRecordId = null;

            // Check if there are any pending records
            $pendingCount = $this->getQuery()->count();

            if ($pendingCount === 0) {
                // Get the current tenant
                $tenant = filament()->getTenant();

                // Redirect to dashboard if no pending records
                $this->redirect(route('filament.app.pages.app-dashboard', ['tenant' => $tenant]), navigate: true);
            }

            // Get first record based on current ordering
            $first = $this->getQuery()
                ->first();

            $this->selectedRecordId = $first?->id;

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

    #[On('outcome-recorded')]
    public function handleOutcomeRecorded(int $recordId): void
    {
        // If a new record was loaded by OutcomeRecorder, select it
        if ($recordId > 0) {
            $this->selectedRecordId = $recordId;
        } else {
            // Otherwise get the first pending record
            $first = $this->getQuery()->first();
            $this->selectedRecordId = $first?->id;
        }

        // Dispatch event to inform widgets of the selected record
        if ($this->selectedRecordId) {
            $this->dispatch('record-selected', recordId: $this->selectedRecordId);
        }
    }

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

    protected function getQuery(): Builder
    {
        $now = now();

        $query = self::getResource()::getEloquentQuery()
            // Only records for current user or team
            ->where(function (Builder $query) {
                $query->where('user_id', Auth::id());
                if (filament()->getTenant()) {
                    $query->orWhere('team_id', filament()->getTenant()->id);
                }
            })
            // Only active records
            ->where('is_active', true)
            // Only records where current date is between started_at and expires_at
            ->whereDate('started_at', '<=', $now)
        //    ->whereDate('expires_at', '>=', $now)
            // Only records where attempts < max_retry_count from outcome_settings
            ->where(function (Builder $query) {
                $query->whereRaw('attempts < COALESCE((
                    SELECT MAX(max_retry_count)
                    FROM outcome_settings
                    WHERE is_active = TRUE
                ), 3)');
            })
            // Only records where current datetime is after available_at OR available_at is null
            ->where(function (Builder $query) use ($now) {
                $query->whereNull('available_at')
                    ->orWhere('available_at', '<=', $now);
            })
            // Only records where current datetime is after aterkom_at OR aterkom_at is null
            ->where(function (Builder $query) use ($now) {
                $query->whereNull('aterkom_at')
                    ->orWhere('aterkom_at', '<=', $now);
            })
            // Only records that haven't been processed (no outcome_category set)
            ->whereNull('outcome_category')
            // Also ensure no outcome is set
            ->whereNull('outcome')
            // Order by id ascending (lowest ID first)
            ->orderBy('id', 'desc');

        return $query;
    }

    protected function getHeaderWidgets(): array
    {
        return [

            RingaDataPinpointWidget::class,
            RingaDataDisplayWidget::class,
            RingaDataOutcomeFormWidget::class,
            RingaDataOutcomeWidget::class,
                    RingaDatasQueueTableWidget::class,
            RingaDataCalendar::class,

        ];
    }
}
