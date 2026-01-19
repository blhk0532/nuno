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
    <div class="border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden" style="height: 700px;">
        @livewire(\App\Filament\App\Clusters\Services\Resources\Bookings\Widgets\BookingCalendar::class, ['lazy' => false, 'pageFilters' => ['booking_calendars' => $selectedCalendar]])
    </div>
</div>
