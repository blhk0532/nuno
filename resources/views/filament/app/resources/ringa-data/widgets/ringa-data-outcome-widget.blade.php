<x-filament-widgets::widget>
    <x-filament::section>
        @if ($this->record)
            <div class="space-y-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <strong>Person:</strong> {{ $this->record->fornamn }} {{ $this->record->efternamn }}<br>
                    <strong>Telenr:</strong> {{ $this->record->telefon }}<br>
                    <strong>Försök:</strong> {{ $this->record->attempts ?? 0 }}<br>
                    <strong>Utfall:</strong>
                    @if($this->record->outcome)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($this->record->outcome->value === 'Bokad') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @elseif($this->record->outcome->value === 'Stärra') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @elseif($this->record->outcome->value === 'Klickad') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @elseif($this->record->outcome->value === 'Inget Svar') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                            @elseif($this->record->outcome->value === 'Telefonsvar') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($this->record->outcome->value === 'Ej Framkopplad') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @elseif($this->record->outcome->value === 'Ring Tillbaka') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
                            @elseif($this->record->outcome->value === 'Ej Intresserad') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @elseif($this->record->outcome->value === 'Fel Telefonnummer') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @elseif($this->record->outcome->value === 'Upptagen') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @elseif($this->record->outcome->value === 'Nyligen Gjort') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                            @elseif($this->record->outcome->value === 'Återkommer') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                            @endif">
                            {{ $this->record->outcome->getLabel() }}
                        </span>
                    @else
                        <span class="text-gray-500">None</span>
                    @endif
                </div>

                @php
                    $phoneNumbers = $this->record->telfonnummer ?? [];
                @endphp

                @if (!empty($phoneNumbers))
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        @foreach($phoneNumbers as $phone)
                            @php $dialable = preg_replace('/\s+/', '', $phone); @endphp
                            <x-filament::button
                                tag="a"
                                href="tel:{{ $dialable }}"
                                color="primary"
                                icon="heroicon-o-phone"
                                size="sm"
                                class="w-full justify-start whitespace-nowrap flex-nowrap flex"
                            >
                                {{ $phone }}
                            </x-filament::button>
                        @endforeach
                    </div>
                @else
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        No phone numbers available.
                    </div>
                @endif
            </div>
        @else
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                <p>Select a record from the table to record call outcomes.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
