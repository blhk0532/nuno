{{-- Placeholder view to avoid missing view exceptions from FilamentBookingPlugin --}}
<div class="filament-calendar-topbar-icon" style="display:none;"></div>
@php
$isSidebarCollapsibleOnDesktop = filament()->isSidebarCollapsibleOnDesktop();
$anderia = \Andreia\FilamentUiSwitcher\Support\UiPreferenceManager::get('ui.layout', 'sidebar');
$aSiderbar = $anderia === 'sidebar-no-topbar' ? true : false;
@endphp
<div class="fi-no-database" x-data>
<div>
<div class="fi-modal-trigger">
<button
    color="gray"
    icon="heroicon-o-calendar-days"
    icon-size="lg"
    label="Kalender"
    @if($anderia === 'sidebar-no-topbar')
    class="fi-sidebar-database-notifications-btn"
    @else
    class="fi-icon-btn fi-size-md fi-topbar-database-notifications-btn"
    @endif
    wire:click="$dispatch('open-modal', { id: 'calendar-modal' })"
>

        <x-filament::icon
            icon="heroicon-o-calendar-days"
            class="fi-icon fi-size-lg"
        />
@php
// dd($anderia);
@endphp

  @if($anderia === 'sidebar-no-topbar')



    <span

            x-show="$store.sidebar.isOpen"
            x-transition:enter="fi-transition-enter"
            x-transition:enter-start="fi-transition-enter-start"
            x-transition:enter-end="fi-transition-enter-end"

        class="fi-sidebar-database-notifications-btn-label"
    >
    NDS Kalender
    </span>
@endif

</button>
 </div>
</div>
</div>

<x-filament::modal id="calendar-modal" class="calendar-modal" slide-over width="3xl">
    <x-slot name="heading">
        Bokningskalener
    </x-slot>
     @livewire('calendar-icon-modal')

</x-filament::modal>
