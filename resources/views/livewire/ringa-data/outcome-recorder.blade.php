<div class="h-full">
    <div class="outcome-recorder space-y-6 h-full flex flex-col">
        @if($record && $this->tenant)
            <div class="space-y-4 flex-grow">
                @php
                    $outcomes = \App\Models\OutcomeSetting::where('is_active', true)
                        ->orderByRaw('CASE WHEN `order` = 0 THEN 999999 ELSE `order` END ASC')
                        ->orderBy('created_at')
                        ->get();
                @endphp

                @if($outcomes->count() > 0)
                <div class="space-y-2">
                    <div class="grid grid-cols-4 gap-2 items-stretch">
                        @foreach($outcomes as $outcome)
                            <div class="w-full h-full flex" wire:key="outcome-{{ $outcome->id }}">
                                @if($outcome->outcome === 'RingTillbaka')
                                    {{ ($this->returnCallAction)(['class' => 'w-full shadow-sm']) }}
                                @elseif($outcome->outcome === 'Aterkommer')
                                    {{ ($this->aterkommerAction)(['class' => 'w-full shadow-sm']) }}
                                @elseif($outcome->outcome === 'NyligenGjort')
                                    {{ ($this->nextGangAction)(['class' => 'w-full shadow-sm']) }}
                                @elseif($outcome->outcome === 'Offert')
                                    {{ ($this->offertAction)(['class' => 'w-full shadow-sm']) }}
                                @elseif($outcome->outcome === 'Bokad')
                                    {{ ($this->bokadAction)(['class' => 'w-full shadow-sm']) }}
                                @else
                                    <button
                                        wire:click="recordOutcome({{ json_encode($outcome->outcome) }})"
                                        style="background-color: {{ $outcome->color }} !important; color: white !important;"
                                        class="w-full h-full px-3 py-2 rounded-lg font-semibold text-sm shadow-sm hover:shadow-md transition-opacity"
                                    >
                                        {{ $outcome->title ?? $outcome->type }}
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        @else
            <div class="p-4 text-center text-gray-500 flex-grow flex items-center justify-center">
                @if(!$this->tenant)
                   zzz...
                @else
                    No record loaded
                @endif
            </div>
        @endif
    </div>

    <x-filament-actions::modals />
</div>

<style>
    /* Prevent Filament action buttons from dimming when component has wire:loading state */
    .outcome-recorder .fi-btn {
        opacity: 1 !important;
    }
</style>



