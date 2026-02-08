<x-filament-widgets::widget class="h-full outcome-form-widget">
    <x-filament::section class="h-full">
        @php
            $recordId = $this->record?->id;
            $tenant = $this->tenant;
        @endphp

        @if($recordId && $tenant)
            <livewire:ringa-data.outcome-recorder :record-id="$recordId" :tenant="$tenant" class="h-full" />
        @elseif(!$tenant)
            <div class="p-4 pt-12 text-center text-red-500">∘ ⴵ ∘</div>
        @else
            <div class="p-4 text-center text-gray-500">zzz</div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
