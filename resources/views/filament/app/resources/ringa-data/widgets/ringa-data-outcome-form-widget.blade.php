<x-filament-widgets::widget class="h-full outcome-form-widget">
    <x-filament::section class="h-full">
        <x-slot name="heading">
            Call Outcomes @if($this->record) - {{ $this->record->telefon }} @endif
        </x-slot>

        @php
            $recordId = $this->record?->id;
            $tenant = $this->tenant;
        @endphp

        @if($recordId && $tenant)
            <livewire:ringa-data.outcome-recorder :record-id="$recordId" :tenant="$tenant" class="h-full" />
        @elseif(!$tenant)
            <div class="p-4 text-center text-red-500">Error: Tenant not found</div>
        @else
            <div class="p-4 text-center text-gray-500">zzz</div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
