<?php

namespace App\Filament\App\Resources\RingaData\Widgets;

use App\Filament\App\Resources\RingaData\Tables\RingaDataTable;
use App\Models\RingaData;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Livewire\Attributes\On;

class RingaDataTableWidget extends BaseWidget
{
    public ?int $recordId = null;

    protected static ?string $heading = ' ';

    protected int | string | array $columnSpan = 'full';

    public function mount(?int $recordId = null): void
    {
        $this->recordId = $recordId;
    }

    #[On('record-selected')]
    public function updateRecordId(int $recordId): void
    {
        $this->recordId = $recordId;
    }

    public function table(Table $table): Table
    {
        return RingaDataTable::configure($table)
            ->query(function () {
                return \App\Models\RingaData::query()->where('user_id', auth()->id());
            })
            ->paginated(true)
            ->emptyStateHeading('Inga resultat hittades')
            ->emptyStateDescription('Du har inga poster tilldelade dig ännu.');
    }
}
