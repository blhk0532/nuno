<style>
.fi-input-wrp.fi-fo-rich-editor {
    min-height: 80vh;
}
#user-notes-modal{
position: absolute;
}
</style>
<script>
    // Intentionally minimal — rely on Filament/Alpine assets for RichEditor initialization.
</script>

<script>
    // App-level safe stub: prevents Alpine ReferenceErrors if the upstream richEditorFormComponent
    // script hasn't loaded yet. Non-invasive — the real implementation will initialize the editor
    // when it becomes available.
    if (typeof window.richEditorFormComponent === 'undefined') {
        window.richEditorFormComponent = function (opts = {}) {
            return {
                state: opts.state ?? {},
                activePanel: opts.activePanel ?? null,
                isUploadingFile: false,
                fileValidationMessage: null,
                editorUpdatedAt: Date.now(),
                isPanelActive: (panel = null) => false,
                getEditor: () => null,
                $getEditor() { return this.getEditor(); },
                init() {
                    // no-op: real component will re-initialize the editor when its script loads
                },
            };
        };
    }
</script>

<div
    class="w-full"
    x-init="$nextTick(() => window.dispatchEvent(new Event('resize')))"
    x-on:calendar-resize.window="window.dispatchEvent(new Event('resize'))"
    x-on:open-modal.window="if ($event.detail && $event.detail.id === 'calendar-modal') { setTimeout(() => window.dispatchEvent(new Event('resize')), 50); setTimeout(() => window.dispatchEvent(new Event('resize')), 250); setTimeout(() => window.dispatchEvent(new Event('resize')), 400); }"
>
    <div class="user-notes-widget-wrapper m-1" id="user-notes-widget-wrapper">

            <div x-data="{ isUploadingFile: false, fileValidationMessage: null, editorUpdatedAt: null, isPanelActive: (panel = null) => false }" x-init>
                <form class="space-y-6" wire:submit="save" @submit.prevent>
                    {{ $this->form }}

                    <div class="flex justify-end">
                        <x-filament::button type="submit">
                            Spara Anteckning
                        </x-filament::button>
                    </div>
                </form>
            </div>

    </div>
</div>
