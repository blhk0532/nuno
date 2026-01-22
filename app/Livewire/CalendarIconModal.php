<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\BookingCalendar as BookingCalendarModel;
use Livewire\Component;

final class CalendarIconModal extends Component
{
    public ?int $selectedCalendar = null;

    public function mount(): void
    {
        // Set first available techniker as default
        $firstCalendar = BookingCalendarModel::query()->with('owner')->first();
        if ($firstCalendar) {
            $this->selectedCalendar = $firstCalendar->id;
        }
    }

    public function updatedSelectedCalendar($value): void
    {
        // Dispatch a browser event so Alpine can trigger a resize,
        // ensuring FullCalendar recalculates its width in the modal.
        $this->dispatch('calendar-resize');
    }

    public function render()
    {
        return view('livewire.calendar-icon-modal');
    }
}
