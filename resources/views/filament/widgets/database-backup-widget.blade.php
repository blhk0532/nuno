<x-filament-widgets::widget>
    <div class="p-4">
        <h3 class="text-lg font-semibold">Database Backup</h3>
        <p class="text-sm text-gray-600 mb-4">Create a backup of the database.</p>
        {{ $this->backupAction }}
    </div>
</x-filament-widgets::widget>
