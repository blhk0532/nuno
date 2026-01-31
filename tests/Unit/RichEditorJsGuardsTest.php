<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert as PHPUnit;

it('provides app-level Alpine defaults for the rich editor and does not modify upstream plugin files', function (): void {
    $appBlade = file_get_contents(base_path('resources/views/livewire/user-notes-modal.blade.php'));

    PHPUnit::assertStringContainsString('window.richEditorFormComponent', $appBlade);
    PHPUnit::assertStringContainsString("isPanelActive: (panel = null) => false", $appBlade);

    // Ensure we did not leave guarded typeof checks in Filament plugin files (we avoid editing upstream when possible)
    $pluginBlade = file_get_contents(base_path('plugins/filament/forms/resources/views/components/rich-editor.blade.php'));
    PHPUnit::assertStringNotContainsString("typeof isUploadingFile !== 'undefined'", $pluginBlade);

    $pluginPhp = file_get_contents(base_path('plugins/filament/forms/src/Components/RichEditor/RichEditorTool.php'));
    PHPUnit::assertStringNotContainsString("typeof editorUpdatedAt !== 'undefined'", $pluginPhp);
});
