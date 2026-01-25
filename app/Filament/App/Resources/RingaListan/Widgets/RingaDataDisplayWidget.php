<?php

namespace App\Filament\App\Resources\RingaListan\Widgets;

use App\Models\RingaData;
use Filament\Widgets\Widget;

class RingaDataDisplayWidget extends Widget
{
    protected string $view = 'filament.app.resources.ringa-data.widgets.ringa-data-display-widget';

    protected int|string|array $columnSpan = 'md';

    protected static ?string $heading = 'Record Details';

    public ?RingaData $record = null;

    protected $listeners = ['record-selected' => 'updateRecord'];

    public function updateRecord(int $recordId): void
    {
        $this->record = RingaData::find($recordId);
    }
}
