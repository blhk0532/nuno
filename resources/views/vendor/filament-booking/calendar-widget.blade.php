@php
    use Filament\Support\Facades\FilamentAsset;
    use Adultdate\FilamentBooking\Enums\Context;
    use Filament\Support\Facades\FilamentColor;
    use Filament\Support\View\Components\ButtonComponent;
@endphp

<x-filament-widgets::widget>
    <x-filament::section
        :after-header="$this->getCachedHeaderActionsComponent()"
        :footer="$this->getCachedFooterActionsComponent()"
    >

        <style>
            .ec-event.ec-preview,
            .ec-now-indicator {
                z-index: 30;
            }
        </style>

        @if($heading = $this->getHeading())
            <x-slot name="heading">
                {{ $this->getHeading() }}
            </x-slot>
        @endif

        @php
            $calendars = \App\Models\BookingCalendar::all()->pluck('name', 'id');
            $options = ['all' => 'Show All'] + $calendars->toArray();
            // Get tenant from current URL by replacing the page part
            $currentUrl = request()->url();
            $singleCalendarUrl = preg_replace('/\/service\/[^\/]+$/', '/single-calendar', $currentUrl);

            // Determine which technician variable to use based on calendar class
            $calendarClass = $this->getCalendarClass();
            $technicianNumber = str_replace('calendar-', '', $calendarClass);
            $technicianVar = 'selectedTechnician' . $technicianNumber;
        @endphp

        <div class="flex flex-col gap-4 md:flex-row md:items-end w-full pb-2">
            {{-- Tekninker --}}
            <div class="flex-1 fi-fo-field-wrp">
                <div class="grid gap-y-2">
                    <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 focus-within:ring-2 fi-fo-select bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-primary-600 dark:focus-within:ring-primary-500 overflow-hidden">
                        <div class="min-w-0 flex-1">
                            <select class="fi-select-input block w-full border-none bg-transparent py-1.5 pl-3 pr-10 text-gray-900 focus:ring-0 sm:text-sm sm:leading-6 dark:text-white" wire:model.live="{{ $technicianVar }}">
                                @foreach($options as $id => $name)
                                    <option value="{{ $id }}" @if($id == $this->{$technicianVar}) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Link Button --}}
            <div class="flex-shrink-0 flex items-center justify-end">
                <a href="{{ $singleCalendarUrl }}?booking_calendars={{ $this->{$technicianVar} }}"
                   onclick="event.preventDefault(); location.href = this.href; return false;"
                   class="fi-btn fi-btn-color-primary relative flex items-center justify-center gap-1 font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-primary fi-size-md fi-btn-size-md gap-x-2 px-3 py-2 text-sm text-white shadow-sm bg-primary-600 hover:bg-primary-500 focus-visible:ring-primary-500/50 sm:whitespace-nowrap w-full md:w-auto">
                    <x-filament::icon icon="heroicon-m-calendar-days" class="w-5 h-5 color-primary text-primary" />
                </a>
            </div>
        </div>

        <div
            wire:ignore
            x-load
            x-load-src="{{ FilamentAsset::getAlpineComponentSrc('calendar', 'adultdate/filament-booking') }}"
            x-data="calendar({
                view: @js($this->getCalendarView()),
                locale: @js($this->getLocale()),
                firstDay: @js($this->getFirstDay()),
                dayMaxEvents: @js($this->getDayMaxEvents()),
                eventContent: @js($this->getEventContentJs()),
                eventClickEnabled: @js($this->isEventClickEnabled()),
                eventDragEnabled: @js($this->isEventDragEnabled()),
                eventResizeEnabled: @js($this->isEventResizeEnabled()),
                noEventsClickEnabled: @js($this->isNoEventsClickEnabled()),
                dateClickEnabled: @js($this->isDateClickEnabled()),
                dateSelectEnabled: @js($this->isDateSelectEnabled()),
                datesSetEnabled: @js($this->isDatesSetEnabled()),
                viewDidMountEnabled: @js($this->isViewDidMountEnabled()),
                eventAllUpdatedEnabled: @js($this->isEventAllUpdatedEnabled()),
                hasDateClickContextMenu: @js($this->hasContextMenu(Context::DateClick)),
                hasDateSelectContextMenu: @js($this->hasContextMenu(Context::DateSelect)),
                hasEventClickContextMenu: @js($this->hasContextMenu(Context::EventClick)),
                hasNoEventsClickContextMenu: @js($this->hasContextMenu(Context::NoEventsClick)),
                resources: @js($this->getResourcesJs()),
                resourceLabelContent: @js($this->getResourceLabelContentJs()),
                theme: @js($this->getTheme()),
                options: @js($this->getOptions()),
                eventAssetUrl: @js(FilamentAsset::getAlpineComponentSrc('calendar-event', 'adultdate/filament-booking')),
            })"
            @class(FilamentColor::getComponentClasses(ButtonComponent::class, 'primary'))
        >
            <div data-calendar></div>
            @if($this->hasContextMenu())
                <x-filament-booking::context-menu/>
            @endif
        </div>
    </x-filament::section>
        <x-filament-actions::modals/>
</x-filament-widgets::widget>
