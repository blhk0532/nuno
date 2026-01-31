<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Filament\App\Pages\ManuSettings;
use App\Models\BookingCalendar as BookingCalendarModel;
use Livewire\Component;

final class ManusIconModal extends Component
{
    public ?int $currentUser = null;

    public function mount(): void
    {

    }

   public function getCachedSubNavigation(): array
    {
        return [];
    }

    public function render()
    {
        $settingsPage = new ManuSettings();
        
        return view('livewire.manus-icon-modal', [
            'form' => $settingsPage->form(new \Filament\Schemas\Schema()),
        ]);
    }
}
