<div x-data="{ phoneNumber: '', status: 'idle', muted: false }" class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-2 h-2">
            <template x-if="status !== 'idle'">
                <span class="inline-flex items-center gap-1.5 text-xs" :class="status === 'calling' ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'">
                    <template x-if="status === 'calling'">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span>Calling...</span>
                    </template>
                    <template x-if="status === 'hangup'">
                        <x-filament::icon icon="heroicon-o-phone-x-mark" class="w-3 h-3" />
                        <span>Call ended</span>
                    </template>
                    <template x-if="status === 'editing'">
                        <x-filament::icon icon="heroicon-o-pencil" class="w-3 h-3" />
                        <span>Editing</span>
                    </template>
                </span>
            </template>
            <template x-if="muted">
                <x-filament::icon icon="heroicon-c-speaker-x-mark" class="w-4 h-4 text-gray-400" />
            </template>
        </div>
        <div class="text-center">
            <input
                type="text"
                x-model="phoneNumber"
                placeholder="Telefonnummer"
                class="w-full text-2xl text-center bg-transparent border-b-2 border-gray-300 dark:border-gray-600 focus:border-primary-500 focus:outline-none py-2 dark:text-white transition-colors"
                readonly
            />
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <template x-for="i in 9">
            <button
                @click="phoneNumber = phoneNumber + i"
                class="aspect-square rounded-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white text-2xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
            >
                <span x-text="i"></span>
            </button>
        </template>

        <button
            @click="phoneNumber = phoneNumber + '+'"
            class="aspect-square rounded-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white text-2xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
        >
            +
        </button>

        <button
            @click="phoneNumber = phoneNumber + '0'"
            class="aspect-square rounded-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white text-2xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
        >
            0
        </button>

        <button
            @click="phoneNumber = phoneNumber + '#'"
            class="aspect-square rounded-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white text-2xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
        >
            #
        </button>
    </div>

    <div class="flex items-center justify-center gap-4">
        <button
            x-show="phoneNumber.length > 0"
            @click="phoneNumber = phoneNumber.slice(0, -1)"
            class="p-4 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
            title="Delete last digit"
        >
            <x-filament::icon icon="heroicon-o-backspace" class="w-6 h-6" />
        </button>

        <button
            @click="phoneNumber = ''; status = 'idle'"
            class="p-4 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
            title="Clear"
        >
            <x-filament::icon icon="heroicon-o-x-circle" class="w-6 h-6" />
        </button>

        <template x-if="status === 'idle' || status === 'editing'">
            <button
                @click="if (phoneNumber) { status = 'calling' }"
                :disabled="!phoneNumber"
                class="p-4 rounded-full" :class="phoneNumber ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-gray-300 dark:bg-gray-800 text-gray-500 cursor-not-allowed'" focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
                title="Call"
            >
                <x-filament::icon icon="heroicon-o-phone" class="w-6 h-6" />
            </button>
        </template>

        <template x-if="status !== 'idle' && status !== 'editing'">
            <button
                @click="status = 'hangup'"
                class="p-4 rounded-full bg-red-500 hover:bg-red-600 text-white focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
                title="End call"
            >
                <x-filament::icon icon="heroicon-o-phone-x-mark" class="w-6 h-6" />
            </button>
        </template>

        <button
            @click="muted = !muted"
            class="p-4 rounded-full" :class="muted ? 'bg-primary-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all"
            :title="muted ? 'Unmute' : 'Mute'"
        >
            <template x-if="muted">
                <x-filament::icon icon="heroicon-o-speaker-wave" class="w-6 h-6" />
            </template>
            <template x-if="!muted">
                <x-filament::icon icon="heroicon-c-speaker-x-mark" class="w-6 h-6" />
            </template>
        </button>
    </div>
</div>
