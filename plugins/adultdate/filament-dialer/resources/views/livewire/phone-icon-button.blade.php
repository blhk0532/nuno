<x-filament::icon-button
    icon="heroicon-o-phone-arrow-up-right"
    class="fi-color fi-text-color-500 hover:fi-text-color-500 dark:fi-text-color-400 dark:hover:fi-text-color-300 fi-icon-btn fi-size-md shrink-0 grow-0 text-gray-700 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300"
    tooltip="Phone Dialer"
    x-on:click.prevent="$dispatch('open-modal', { id: 'phone-dialer-sidebar' })"
    wire:key="phone-icon-button"
    action="open-modal"
/>
