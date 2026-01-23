<?php

namespace App\Filament\App\Resources\BookingDataLeads\Pages;

use App\Filament\App\Resources\BookingDataLeads\BookingDataLeadResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class RingLista extends Page
{
    use InteractsWithRecord;

    protected static string $resource = BookingDataLeadResource::class;

    protected string $view = 'filament.app.resources.booking-data-leads.pages.ring-lista';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
