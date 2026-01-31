<div
    class="w-full"
    x-data="{ isUploadingFile: false, fileValidationMessage: null, editorUpdatedAt: null, isPanelActive: (panel = null) => false }"
    x-init="$nextTick(() => window.dispatchEvent(new Event('resize')))"
    x-on:calendar-resize.window="window.dispatchEvent(new Event('resize'))"
    x-on:open-modal.window="if ($event.detail && $event.detail.id === 'manus-icon-modal') { setTimeout(() => window.dispatchEvent(new Event('resize')), 50); setTimeout(() => window.dispatchEvent(new Event('resize')), 250); setTimeout(() => window.dispatchEvent(new Event('resize')), 400); }"
>
    <div class="manus-widget-wrapper m-1" id="manus-widget-wrapper">
            <form class="space-y-6" wire:submit="save" @submit.prevent>
                {{ $this->form }}

                <div class="flex justify-end">
                    <x-filament::button type="save">
                        Spara Anteckningar.
                    </x-filament::button>
                </div>
            </form>
    </div>
</div>
