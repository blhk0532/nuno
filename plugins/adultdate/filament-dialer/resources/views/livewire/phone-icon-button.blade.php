<x-filament::icon-button
    icon="heroicon-o-phone-arrow-up-right"
    class="fi-color fi-color-primary fi-text-color-600 hover:fi-text-color-700"
    tooltip="Phone Dialer"
    x-on:click.prevent="$dispatch('open-modal', { id: 'phone-dialer-sidebar' })"
    wire:key="phone-icon-button"
    action="open-modal"
/>
