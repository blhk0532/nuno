<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\RingaDatas\Widgets;

use App\Models\RingaData;
use Filament\Widgets\Widget;

final class RingaDataOutcomeFormWidget extends Widget
{
    public ?RingaData $record = null;

    public ?string $tenant = null;

    protected static ?string $heading = 'Call Outcomes';

    protected int|string|array $columnSpan = '1/2';

    protected static ?int $sort = 2;

    protected string $view = 'filament.app.resources.ringa-data.widgets.ringa-data-outcome-form-widget';

    public function mount(): void
    {
        // Get tenant from Filament (uses slug for routing)
        $tenant = filament()->getTenant();
        $this->tenant = $tenant ? $tenant->slug : null;
        logger('Widget tenant set from Filament', ['tenant' => $this->tenant, 'tenant_id' => $tenant?->id, 'tenant_slug' => $tenant?->slug]);

        // Load the first unprocessed record directly
        // This bypasses Filament's data-passing mechanism which isn't working
        $this->record = RingaData::where('is_outcome', false)
            ->orderBy('id')
            ->first();
    }
}
