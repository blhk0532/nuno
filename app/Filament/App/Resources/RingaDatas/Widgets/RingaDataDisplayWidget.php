<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Widgets;

use App\Models\RingaData;
use Filament\Widgets\Widget;

final class RingaDataDisplayWidget extends Widget
{
    public ?RingaData $record = null;

    protected string $view = 'filament.app.resources.ringa-data.widgets.ringa-data-display-widget';

    protected int|string|array $columnSpan = 'md';

    protected static ?string $heading = 'Record Details';

    protected $listeners = ['record-selected' => 'updateRecord'];

    public function updateRecord(int $recordId): void
    {
        $this->record = RingaData::find($recordId);
    }
}
