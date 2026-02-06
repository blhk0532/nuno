<?php

declare(strict_types=1);

it('loads all Filament resource classes without fatal errors', function () {
    $files = glob(app_path('Filament').'/**/*Resource.php');

    foreach ($files as $file) {
        $class = str_replace([app_path().DIRECTORY_SEPARATOR, '.php'], ['', ''], $file);
        $class = str_replace(DIRECTORY_SEPARATOR, '\\', $class);

        expect(class_exists($class))->toBeTrue()->with("Class $class exists");

        // calling a couple of static methods that exercise property/type resolution
        expect(method_exists($class, 'getModel'))->toBeTrue()->with("$class::getModel exists");
        $model = $class::getModel();
        expect(is_string($model))->toBeTrue()->with("$class::getModel returns string");
    }
});
