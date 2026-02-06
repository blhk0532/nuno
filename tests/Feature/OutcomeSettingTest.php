<?php

declare(strict_types=1);

use App\Models\OutcomeSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('outcome setting can be created', function () {
    $setting = OutcomeSetting::factory()->create([
        'type' => 'Success',
    ]);

    expect($setting->type)->toBe('Success');
    expect(OutcomeSetting::query()->count())->toBe(1);
});

test('outcome setting supports optional fields', function () {
    $setting = OutcomeSetting::factory()->create([
        'color' => '#0ea5e9',
        'icon' => 'heroicon-o-check-circle',
        'description' => 'Successful outcome.',
        'is_active' => true,
    ]);

    expect($setting->color)->toBe('#0ea5e9');
    expect($setting->icon)->toBe('heroicon-o-check-circle');
    expect($setting->description)->toBe('Successful outcome.');
    expect($setting->is_active)->toBeTrue();
});
