<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ResourcesAutoloadPhpTest extends TestCase
{
    public function test_all_filament_resources_autoload(): void
    {
        $dir = __DIR__.'/../../app/Filament';

        $files = (function (string $dir) {
            $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
            $out = [];

            foreach ($rii as $file) {
                if ($file->isDir()) {
                    continue;
                }

                if (str_ends_with($file->getFilename(), 'Resource.php') || str_ends_with($file->getFilename(), 'Page.php')) {
                    $out[] = $file->getPathname();
                }
            }

            return $out;
        })($dir);

        foreach ($files as $file) {
            $contents = file_get_contents($file);

            // derive FQCN from namespace + class name without booting Laravel
            if (preg_match('#namespace\s+([^;]+);#', $contents, $m) && preg_match('#class\s+(\w+)#', $contents, $m2)) {
                $fqcn = $m[1].'\\'.$m2[1];

                // autoload via Composer (should not bootstrap Laravel)
                $this->assertTrue(class_exists($fqcn), "Class $fqcn should be autoloadable (file: $file)");
            }
        }
    }
}
