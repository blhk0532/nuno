<x-filament-widgets::widget>
    <x-filament::section>
        @if ($this->record)
            <div class="space-y-3">
                <div class="grid grid-cols-2 gap-3 mt-3">
                    <div class="col-span-2 hidden">
                        <h3 class="text-lg font-bold">{{ $this->record->personnamn }}</h3>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Förnamn</p>
                        <p class="font-medium text-queue-card">{{ $this->record->fornamn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Efternamn</p>
                        <p class="font-medium text-queue-card">{{ $this->record->efternamn ?? '-' }}</p>
                    </div>

                    <!-- Address Information -->
                    <div class="col-span-1">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Adress</p>
                        <p class="font-medium text-queue-card">{{ $this->record->gatuadress ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Postkod</p>
                        <p class="font-medium text-queue-card">{{ $this->record->postnummer ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kommun</p>
                        <p class="font-medium text-queue-card">{{ $this->record->kommun ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Postort</p>
                        <p class="font-medium text-queue-card">{{ $this->record->postort ?? '-' }}</p>
                    </div>
                    <!-- Personal Information -->


                    <!-- Identification -->
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Personnummer</p>
                        <p class="font-medium text-queue-card">{{ $this->record->personnummer ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kön</p>
                        <p class="font-medium text-queue-card">{{ $this->record->kon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Civilstånd</p>
                        <p class="font-medium text-queue-card">{{ $this->record->civilstand ?? '-' }}</p>
                    </div>


                    <!-- Housing Information -->
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Bostadstyp</p>
                        <p class="font-medium text-queue-card">{{ $this->record->bostadstyp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Ägandeform</p>
                        <p class="font-medium text-queue-card">{{ $this->record->agandeform ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Byggår</p>
                        <p class="font-medium text-queue-card">{{ $this->record->byggar ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Adressändring</p>
                        <p class="font-medium text-queue-card">{{ $this->record->adressandring ?? '-' }}</p>
                    </div>

                    <!-- Business & Assets -->
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Bolagsengagemang</p>
                        <p class="font-medium text-queue-card">
                            @if($this->record->bolagsengagemang && is_array($this->record->bolagsengagemang))
                                {{ count($this->record->bolagsengagemang) }}
                            @else
                                0
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Fordon</p>
                        <p class="font-medium text-queue-card">
                            @if($this->record->fordon && is_array($this->record->fordon))
                                {{ count($this->record->fordon) }}
                            @else
                                0
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Personer</p>
                        <p class="font-medium text-queue-card">
                            @if($this->record->personer && is_array($this->record->personer))
                                {{ count($this->record->personer) }}
                            @else
                                0
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Företag</p>
                        <p class="font-medium text-queue-card">
                            @if($this->record->foretag && is_array($this->record->foretag))
                                {{ count($this->record->foretag) }}
                            @else
                                0
                            @endif
                        </p>
                </div>
         <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Epost Adres</p>
                        <p class="font-medium text-queue-card">
                            @if($this->record->epost_adress && is_array($this->record->epost_adress) && count($this->record->epost_adress) > 0)
                                {{ implode(', ', $this->record->epost_adress) }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Telefon</p>
                        <p class="font-medium text-queue-card">{{ $this->record->telefon ?? '-' }}</p>
                    </div>

                                  <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Telefonnummer</p>
                        <p class="font-medium text-queue-card">
                            @if($this->record->telfonnummer && is_array($this->record->telfonnummer) && count($this->record->telfonnummer) > 0)
                                {{ implode(', ', $this->record->telfonnummer) }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
            </div>
        @else
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                <p>Select a record from the table to view details.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
