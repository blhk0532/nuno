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
use Livewire\Attributes\On;
use UnitEnum;
use Wallacemartinss\FilamentIconPicker\Enums\Tabler;

final class QueueRingaData extends Page
{
    public ?int $selectedRecordId = null;

    protected static string $resource = RingaDatasResource::class;

    protected static ?string $slug = 'queue';

    protected static ?string $model = RingaData::class;

    protected static ?string $navigationLabel = 'Ringlistan';

    protected static ?string $title = 'Ringlistan';

    // public static bool $shouldRegisterNavigation = true;

    protected static UnitEnum|string|null $navigationGroup = ' ';

    protected static ?int $navigationSort = 4;

    protected static ?int $sort = 4;

    protected static string|BackedEnum|null $navigationIcon = Tabler::PhoneRinging;

    protected string $view = 'filament.app.resources.ringa-data.pages.queue';

    public static function getNavigationBadge(): ?string
    {
        return (string) self::getResource()::getEloquentQuery()
            ->whereNull('outcome')
            ->where('available_at', '<=', now())
            ->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
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
            })
            ->where('available_at', '<=', now())
            ->where(function (Builder $query) {
                // Show records where retry_count < max_retry_count for their most recent outcome
                // For records without an outcome, we check against the default max retry counts
                $query->where('outcome', null)
                    ->orWhere(function (Builder $subQuery) {
                        // Check that retry_count is less than the configured max for this outcome
                        $subQuery->whereRaw('retry_count < (
                            SELECT COALESCE(max_retry_count, 3)
                            FROM outcome_delay_settings
                            WHERE outcome = ringa_data.outcome AND is_active = TRUE
                            LIMIT 1
                        )');
                    });
            })
            ->orderBy('gatuadress');
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
}
