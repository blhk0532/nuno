<?php

namespace App\Filament\App\Resources\BookingDataLeads\Pages;

use App\Filament\App\Resources\BookingDataLeads\BookingDataLeadResource;
use Filament\Resources\Pages\Page;

class Dashboard extends Page
{
    protected static string $resource = BookingDataLeadResource::class;

    protected string $view = 'filament.app.resources.booking-data-leads.pages.dashboard';
}
