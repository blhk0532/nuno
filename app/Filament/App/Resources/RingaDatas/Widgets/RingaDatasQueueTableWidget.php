<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Widgets;

use App\Filament\App\Resources\RingaDatas\Tables\RingaDatasTable;
use App\Models\RingaData;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Livewire\Attributes\On;

final class RingaDatasQueueTableWidget extends BaseWidget
{
    public ?int $recordId = null;

    protected static ?string $heading = '';

    protected int|string|array $columnSpan = 'full';

    public function mount(?int $recordId = null): void
    {
        logger()->info('RingaDatasQueueTableWidget mount', ['recordId' => $recordId]);
        $this->recordId = $recordId;
    }

    #[On('record-selected')]
    public function updateRecordId(int $recordId): void
    {
        logger()->info('RingaDatasQueueTableWidget updateRecordId', ['recordId' => $recordId]);
        $this->recordId = $recordId;
    }

    public function table(Table $table): Table
    {
        // Safely try to get the ID from local state, page object, or calculated fallback
        $page = $this->getPage();
        $pageId = (is_object($page) && property_exists($page, 'selectedRecordId')) ? $page->selectedRecordId : null;

        $id = $this->recordId ?? $pageId;

        // If still no ID, try to find the "current" one just like the page does
        if (! $id) {
            $id = \App\Filament\App\Resources\RingaDatas\RingaDatasResource::getEloquentQuery()
                ->where(function ($query) {
                    $query->where('is_active', true);
                    //    ->orWhere('attempts', '<', 3);
                })
                ->where('available_at', '<=', now())
                ->orderBy('gatuadress')
                ->first()
                ?->id;
        }

        logger()->info('RingaDatasQueueTableWidget table query', [
            'final_id' => $id,
            'local_id' => $this->recordId,
            'page_id' => $pageId,
        ]);

        return RingaDatasTable::configure($table)
            ->query(function () use ($id) {
                if (! $id) {
                    return RingaData::query()->whereRaw('1=0');
                }

                return \App\Filament\App\Resources\RingaDatas\RingaDatasResource::getEloquentQuery()->where('id', (int) $id);
            })
            ->paginated(false)
            ->emptyStateHeading('Ingen aktuell post vald')
            ->emptyStateDescription('Välj en post från listan eller kalendern för att se detaljer.');
    }
}
