<x-filament-widgets::widget>
    <x-slot name="heading">
        Call Outcomes @if($this->record) - {{ $this->record->telefon }} @endif
    </x-slot>

    @php
        $recordId = $this->record?->id;
    @endphp

    @if($recordId)
        <livewire:ringa-data.outcome-recorder :record-id="$recordId" />
    @endif
</x-filament-widgets::widget>
