<div>
    <button
        type="button"
        wire:click="mountAction('openCalendar')"
        class="relative inline-flex items-center justify-center h-10 w-10 rounded-lg text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 transition-colors duration-200"
        title="Open Calendar"
    >
        <x-filament::icon
            icon="heroicon-o-calendar-days"
            class="h-6 w-6"
        />
    </button>

    <x-filament-actions::modals />
</div>
