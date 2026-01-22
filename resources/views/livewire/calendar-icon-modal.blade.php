<div
    class="w-full"
    x-init="$nextTick(() => window.dispatchEvent(new Event('resize')))"
    x-on:calendar-resize.window="window.dispatchEvent(new Event('resize'))"
    x-on:open-modal.window="if ($event.detail && $event.detail.id === 'calendar-modal') { setTimeout(() => window.dispatchEvent(new Event('resize')), 50); setTimeout(() => window.dispatchEvent(new Event('resize')), 250); setTimeout(() => window.dispatchEvent(new Event('resize')), 400); }"
>
    <!-- Techniker Filter -->
    <div class="mb-4">
        <select wire:model.live="selectedCalendar" class="fi-input block w-full">
            @foreach(\App\Models\BookingCalendar::with('owner')->get() as $calendar)
                <option value="{{ $calendar->id }}">{{ $calendar->owner?->name ?? $calendar->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Calendar -->
    <div class="calendar-widget-wrapper" wire:key="booking-calendar-{{ $selectedCalendar ?? 'none' }}">
        @livewire(\App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\BookingCalendar::class, ['lazy' => false, 'pageFilters' => ['booking_calendars' => $selectedCalendar]], key('booking-calendar-'.$selectedCalendar))
    </div>
</div>
