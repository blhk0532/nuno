<div class="h-full">
    <div class="outcome-recorder space-y-6 h-full flex flex-col">
        @if($record && $this->tenant)
            <div class="space-y-4 flex-grow">
                <!-- Outcomes 1: Critical/Negative -->
                <div class="space-y-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-danger-600 dark:text-danger-400 hidden">Avslut/Problem</h4>
                    <div class="grid grid-cols-4 gap-2 items-stretch">
                        @foreach(\App\Enums\Outcomes1::cases() as $outcome)
                            <form method="POST" action="{{ route('ringa-data.outcome.store', ['tenant' => $this->tenant, 'id' => $record->id]) }}" class="w-full h-full flex">
                                @csrf
                                <input type="hidden" name="outcome" value="{{ $outcome->name }}" />
                                <x-filament::button
                                    type="submit"
                                    :color="$outcome->getColor()"
                                    size="sm"
                                    class="w-full h-full shadow-sm"
                                >
                                    {{ $outcome->getLabel() }}
                                </x-filament::button>
                            </form>
                        @endforeach
                    </div>
                </div>

                <!-- Outcomes 2: Temporary/Warning -->
                <div class="space-y-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-warning-600 dark:text-warning-400 hidden">Inget Svar/Upptagen</h4>
                    <div class="grid grid-cols-4 gap-2 items-stretch">
                        @foreach(\App\Enums\Outcomes2::cases() as $outcome)
                            <form method="POST" action="{{ route('ringa-data.outcome.store', ['tenant' => $this->tenant, 'id' => $record->id]) }}" class="w-full h-full flex">
                                @csrf
                                <input type="hidden" name="outcome" value="{{ $outcome->name }}" />
                                <x-filament::button
                                    type="submit"
                                    :color="$outcome->getColor()"
                                    size="sm"
                                    class="w-full h-full shadow-sm"
                                >
                                    {{ $outcome->getLabel() }}
                                </x-filament::button>
                            </form>
                        @endforeach
                    </div>
                </div>

                <!-- Outcomes 4: Positive/Follow-up -->
                <div class="space-y-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-primary-600 dark:text-primary-400 hidden">Bokning/Återkoppling</h4>
                    <div class="grid grid-cols-4 gap-2 items-stretch">
                        @foreach(\App\Enums\Outcomes4::cases() as $outcome)
                            <div class="flex">
                                @if($outcome->name === 'RingTillbaka')
                                    {{ ($this->returnCallAction)(['class' => 'w-full shadow-sm', 'size' => 'sm']) }}
                                @elseif($outcome->name === 'Aterkommer')
                                    {{ ($this->aterkommerAction)(['class' => 'w-full shadow-sm', 'size' => 'sm']) }}
                                @else
                                    <form method="POST" action="{{ route('ringa-data.outcome.store', ['tenant' => $this->tenant, 'id' => $record->id]) }}" class="w-full h-full">
                                        @csrf
                                        <input type="hidden" name="outcome" value="{{ $outcome->name }}" />
                                        <x-filament::button
                                            type="submit"
                                            :color="$outcome->getColor()"
                                            size="sm"
                                            class="w-full h-full shadow-sm"
                                        >
                                            {{ $outcome->getLabel() }}
                                        </x-filament::button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="p-4 text-center text-gray-500 flex-grow flex items-center justify-center">
                @if(!$this->tenant)
                    Error: Tenant not found
                @else
                    No record loaded
                @endif
            </div>
        @endif
    </div>

    <x-filament-actions::modals />
</div>



