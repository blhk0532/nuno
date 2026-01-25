<div>
    <section class="fi-section">
        <div class="fi-section-content-ctn">
            <div class="fi-section-content">
                <div class="outcome-recorder space-y-4">
                    @if($record && $this->tenant)
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Outcomes 1 -->
                            <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-4 gap-2">
                                @foreach(\App\Enums\Outcomes1::cases() as $outcome)
                                    <form method="POST" action="{{ route('ringa-data.outcome.store', ['tenant' => $this->tenant, 'id' => $record->id]) }}" class="w-full">
                                        @csrf
                                        <input type="hidden" name="outcome" value="{{ $outcome->name }}" />
                                        <button type="submit" class="w-full px-3 py-2 rounded text-sm font-medium text-white outcome-button {{ $this->getColorClass($outcome->getColor()) }}">
                                            {{ $outcome->getLabel() }}
                                        </button>
                                    </form>
                                @endforeach
                            </div>

                            <!-- Outcomes 2 -->
                            <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-4 gap-2">
                                @foreach(\App\Enums\Outcomes2::cases() as $outcome)
                                    <form method="POST" action="{{ route('ringa-data.outcome.store', ['tenant' => $this->tenant, 'id' => $record->id]) }}" class="w-full">
                                        @csrf
                                        <input type="hidden" name="outcome" value="{{ $outcome->name }}" />
                                        <button type="submit" class="w-full px-3 py-2 rounded text-sm font-medium text-white outcome-button {{ $this->getColorClass($outcome->getColor()) }}">
                                            {{ $outcome->getLabel() }}
                                        </button>
                                    </form>
                                @endforeach
                            </div>

                            <!-- Outcomes 4 (includes Ring Tillbaka and Återkom) -->
                            <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-4 gap-2">
                                @foreach(\App\Enums\Outcomes4::cases() as $outcome)
                                    @if($outcome->name === 'RingTillbaka')
                                        <button
                                            type="button"
                                            wire:click="mountAction('returnCall')"
                                            class="w-full px-3 py-2 rounded text-sm font-medium text-white outcome-button {{ $this->getColorClass($outcome->getColor()) }}"
                                        >
                                            {{ $outcome->getLabel() }}
                                        </button>
                                    @elseif($outcome->name === 'Aterkommer')
                                        <button
                                            type="button"
                                            wire:click="mountAction('aterkommer')"
                                            class="w-full px-3 py-2 rounded text-sm font-medium text-white outcome-button {{ $this->getColorClass($outcome->getColor()) }}"
                                        >
                                            {{ $outcome->getLabel() }}
                                        </button>
                                    @else
                                        <form method="POST" action="{{ route('ringa-data.outcome.store', ['tenant' => $this->tenant, 'id' => $record->id]) }}" class="w-full">
                                            @csrf
                                            <input type="hidden" name="outcome" value="{{ $outcome->name }}" />
                                            <button type="submit" class="w-full px-3 py-2 rounded text-sm font-medium text-white outcome-button {{ $this->getColorClass($outcome->getColor()) }}">
                                                {{ $outcome->getLabel() }}
                                            </button>
                                        </form>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        @if(!$this->tenant)
                            <div class="p-4 text-center text-red-500">Error: Tenant not found</div>
                        @else
                            <div class="p-4 text-center text-gray-500">No record loaded</div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    <x-filament-actions::modals />
</div>



