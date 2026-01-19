<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\BookingCalendar;
use App\Models\BookingCalendar as BookingCalendarModel;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

final class CalendarIconModal extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?int $selectedCalendar = null;

    public function mount(): void
    {
        // Set first available techniker as default
        $firstCalendar = BookingCalendarModel::query()->with('owner')->first();
        if ($firstCalendar) {
            $this->selectedCalendar = $firstCalendar->id;
        }
    }

    public function openCalendarAction(): Action
    {
        return Action::make('openCalendar')
            ->label('Calendar')
            ->icon('heroicon-c-calendar-days')
            ->modalHeading('Booking Calendar')
            ->slideOver()
            ->modalWidth('3xl')
            ->modalContent(view('filament.app.calendar-modal-content', [
                'selectedCalendar' => $this->selectedCalendar,
            ]))
            ->modalSubmitAction(false)
            ->modalCancelAction(false)
            ->closeModalByClickingAway(true)
            ->extraModalFooterActions([]);
    }

    public function render()
    {
        return view('livewire.calendar-icon-modal');
    }
}
