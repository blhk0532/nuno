   <section class="fi-section">
   <div class="fi-section-content-ctn">
    <div class="fi-section-content">
<div class="outcome-recorder space-y-4">
    @if($record)

        <div class="grid grid-cols-1 gap-4">
            @if(\App\Enums\Outcomes1::cases())
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2">
                    @foreach(\App\Enums\Outcomes1::cases() as $outcome)
                        <x-filament::button
                            type="button"
                            wire:click="recordOutcome('{{ $outcome->name }}')"
                            :color="$outcome->getColor()"
                            size="sm"
                            class="w-full"
                        >
                            {{ $outcome->getLabel() }}
                        </x-filament::button>
                    @endforeach
                </div>
            @endif

            @if(\App\Enums\Outcomes2::cases())
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2">
                    @foreach(\App\Enums\Outcomes2::cases() as $outcome)
                        <x-filament::button
                            type="button"
                            wire:click="recordOutcome('{{ $outcome->name }}')"
                            :color="$outcome->getColor()"
                            size="sm"
                            class="w-full"
                        >
                            {{ $outcome->getLabel() }}
                        </x-filament::button>
                    @endforeach
                </div>
            @endif

            @if(\App\Enums\Outcomes4::cases())
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2">
                    @foreach(\App\Enums\Outcomes4::cases() as $outcome)
                        <x-filament::button
                            type="button"
                            wire:click="recordOutcome('{{ $outcome->name }}')"
                            :color="$outcome->getColor()"
                            size="sm"
                            class="w-full"
                        >
                            {{ $outcome->getLabel() }}
                        </x-filament::button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>
 </div>
  </div>
</section>
