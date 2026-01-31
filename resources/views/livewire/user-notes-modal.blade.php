<style>
.fi-input-wrp.fi-fo-rich-editor {
    min-height: 80vh;
}
#user-notes-modal{
position: absolute;
}
</style>
<script>
    // Safe no-op globals to prevent Alpine/Filament RichEditor ReferenceErrors
    if (typeof window.editorUpdatedAt === 'undefined') window.editorUpdatedAt = 0;
    if (typeof window.$getEditor === 'undefined') window.$getEditor = () => ({ isActive: () => false });
    if (typeof window.isPanelActive === 'undefined') window.isPanelActive = () => false;
    if (typeof window.isUploadingFile === 'undefined') window.isUploadingFile = () => false;
    if (typeof window.fileValidationMessage === 'undefined') window.fileValidationMessage = null;
</script>
<div
    class="w-full"
    x-init="$nextTick(() => window.dispatchEvent(new Event('resize')))"
    x-on:calendar-resize.window="window.dispatchEvent(new Event('resize'))"
    x-on:open-modal.window="if ($event.detail && $event.detail.id === 'calendar-modal') { setTimeout(() => window.dispatchEvent(new Event('resize')), 50); setTimeout(() => window.dispatchEvent(new Event('resize')), 250); setTimeout(() => window.dispatchEvent(new Event('resize')), 400); }"
>
    <div class="user-notes-widget-wrapper m-1" id="user-notes-widget-wrapper">

            <div class="space-y-6">
                {{-- DEBUG: show raw property and form state for troubleshooting --}}
                <div class="mb-4 p-2 bg-gray-50 border rounded">
                    <label class="block text-sm font-medium text-gray-700">Debug: anteckningar (wire:model)</label>
                    <textarea wire:model.lazy="anteckningar" class="w-full h-28 p-2 border rounded mt-1"></textarea>
                    <div class="mt-2 text-xs text-gray-600">
                        <strong>Form state (data):</strong>
                        <pre class="whitespace-pre-wrap">{{ json_encode($this->data) }}</pre>
                    </div>
                </div>

                {{ $this->form }}

                <div class="flex justify-end">
                    <x-filament::button type="button" wire:click="save">
                        Spara Anteckning
                    </x-filament::button>
                </div>
            </div>

    </div>
</div>
