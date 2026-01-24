<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            .fi-fo-field-label-content {
                font-size: 8px;
  color: transparent;
            }
        </style>
        <form wire:submit="save" class="space-y-4" wire:key="pinpoint-form-{{ $record?->id ?? 'default' }}">
            {{ $this->form }}
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
