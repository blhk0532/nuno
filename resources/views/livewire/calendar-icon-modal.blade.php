<div class="w-full">
    <!-- Techniker Filter -->
    <div class="mb-4">
        <select wire:model.live="selectedCalendar" class="fi-input block w-full">
            @foreach(\App\Models\BookingCalendar::with('owner')->get() as $calendar)
                <option value="{{ $calendar->id }}">{{ $calendar->owner?->name ?? $calendar->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Calendar -->
    <div class="calendar-widget-wrapper">
        @livewire(\App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\BookingCalendar::class, ['lazy' => false, 'pageFilters' => ['booking_calendars' => $selectedCalendar]])
    </div>
</div>
