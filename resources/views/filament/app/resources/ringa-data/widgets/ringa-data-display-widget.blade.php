<x-filament-widgets::widget>
    <x-filament::section>
        @if ($this->record)
            <div class="space-y-4">
                <!-- Compact Profile Header -->
                <div class="flex items-center gap-4 pb-4 border-b border-gray-100 dark:border-white/5">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl shrink-0 bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400">
                        <x-filament::icon
                            icon="{{ $this->record->kon === 'Kvinna' ? 'heroicon-o-user-circle' : 'heroicon-o-user' }}"
                            class="w-7 h-7"
                        />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-baseline gap-x-3">
                            <h2 class="text-xl font-bold text-gray-950 dark:text-white truncate">
                                {{ $this->record->fornamn }} {{ $this->record->efternamn }}
                            </h2>
                            <span class="text-sm font-mono text-gray-500 dark:text-gray-400 select-all">
                                {{ $this->record->personnummer ?? '-' }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @if($this->record->civilstand)
                                <x-filament::badge size="sm" color="gray" icon="heroicon-m-heart">
                                    {{ $this->record->civilstand }}
                                </x-filament::badge>
                            @endif
                            @if($this->record->kon)
                                <x-filament::badge size="sm" color="gray" icon="heroicon-m-user">
                                    {{ $this->record->kon }}
                                </x-filament::badge>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Address Card -->
                    <div class="relative p-4 overflow-hidden bg-white ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10 rounded-xl transition-all hover:ring-primary-500/30">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="p-1.5 rounded-lg bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400">
                                <x-filament::icon icon="heroicon-o-map-pin" class="w-4 h-4" />
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-tight text-gray-500 dark:text-gray-400">Adress</h4>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] uppercase font-medium text-gray-400 dark:text-gray-500">Gatuadress</p>
                                <p class="text-sm font-semibold tracking-tight leading-4">{{ $this->record->gatuadress ?? '-' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-x-2">
                                <div>
                                    <p class="text-[10px] uppercase font-medium text-gray-400 dark:text-gray-500">Postkod</p>
                                    <p class="text-sm font-semibold tracking-tight">{{ $this->record->postnummer ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-medium text-gray-400 dark:text-gray-500">Ort</p>
                                    <p class="text-sm font-semibold tracking-tight truncate">{{ $this->record->postort ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-medium text-gray-400 dark:text-gray-500">Kommun</p>
                                <p class="text-sm font-semibold tracking-tight">{{ $this->record->kommun ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Housing Card -->
                    <div class="relative p-4 overflow-hidden bg-white ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10 rounded-xl transition-all hover:ring-warning-500/30">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="p-1.5 rounded-lg bg-warning-50 dark:bg-warning-500/10 text-warning-600 dark:text-warning-400">
                                <x-filament::icon icon="heroicon-o-home" class="w-4 h-4" />
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-tight text-gray-500 dark:text-gray-400">Bostad</h4>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] uppercase font-medium text-gray-400 dark:text-gray-500">Bostadstyp & Ägande</p>
                                <p class="text-sm font-semibold tracking-tight leading-4">{{ $this->record->bostadstyp ?? '-' }} • {{ $this->record->agandeform ?? '-' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-x-2">
                                <div>
                                    <p class="text-[10px] uppercase font-medium text-gray-400 dark:text-gray-500">Byggår</p>
                                    <p class="text-sm font-semibold tracking-tight">{{ $this->record->byggar ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-medium text-gray-400 dark:text-gray-500">Flyttdag</p>
                                    <p class="text-sm font-semibold tracking-tight">{{ $this->record->adressandring ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-gray-100 dark:border-white/5">
                                <p class="text-[10px] uppercase font-medium text-gray-400 dark:text-gray-500 mb-1.5">Personer på adressen</p>
                                <div class="flex items-center gap-2">
                                    <div class="flex -space-x-2">
                                        @php $count = is_array($this->record->personer) ? count($this->record->personer) : 0; @endphp
                                        @for($i=0; $i < min($count, 3); $i++)
                                            <div class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 bg-gray-200 dark:bg-gray-800 flex items-center justify-center">
                                                <x-filament::icon icon="heroicon-m-user" class="w-3 h-3 text-gray-400" />
                                            </div>
                                        @endfor
                                    </div>
                                    <span class="text-xs font-bold text-gray-900 dark:text-white">{{ $count }} {{ Str::plural('medlem', $count) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Assets Card -->
                    <div class="relative p-4 overflow-hidden bg-white ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10 rounded-xl transition-all hover:ring-success-500/30">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="p-1.5 rounded-lg bg-success-50 dark:bg-success-500/10 text-success-600 dark:text-success-400">
                                <x-filament::icon icon="heroicon-o-briefcase" class="w-4 h-4" />
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-tight text-gray-500 dark:text-gray-400">Engagemang</h4>
                        </div>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-2.5 rounded-xl bg-gray-50/50 dark:bg-white/5">
                                    <p class="text-[10px] uppercase font-bold text-gray-500">Bolag</p>
                                    <p class="text-lg font-black tracking-tighter text-success-600 dark:text-success-400">{{ is_array($this->record->bolagsengagemang) ? count($this->record->bolagsengagemang) : 0 }}</p>
                                </div>
                                <div class="p-2.5 rounded-xl bg-gray-50/50 dark:bg-white/5">
                                    <p class="text-[10px] uppercase font-bold text-gray-500">Fordon</p>
                                    <p class="text-lg font-black tracking-tighter text-blue-600 dark:text-blue-400">{{ is_array($this->record->fordon) ? count($this->record->fordon) : 0 }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-bold text-gray-500 mb-1">Företag</p>
                                <x-filament::badge color="info" size="sm">
                                    {{ is_array($this->record->foretag) ? count($this->record->foretag) : 0 }} aktiva engagemang
                                </x-filament::badge>
                            </div>
                            <div class="pt-3 border-t border-gray-100 dark:border-white/5">
                                <p class="text-[10px] uppercase font-medium text-gray-400 dark:text-gray-500 mb-1">Primär E-post</p>
                                <p class="text-xs font-semibold truncate text-primary-600 dark:text-primary-400">
                                    @if($this->record->epost_adress && is_array($this->record->epost_adress) && count($this->record->epost_adress) > 0)
                                        {{ $this->record->epost_adress[0] }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                <p>Select a record from the table to view details.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
