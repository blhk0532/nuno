<?php

declare(strict_types=1);

use App\Livewire\UserNotesModal;
use App\Models\User;
use Livewire\Livewire;

test('user notes modal component exists and is callable', function () {
    expect(class_exists(UserNotesModal::class))->toBeTrue();
    expect(method_exists(UserNotesModal::class, 'save'))->toBeTrue();
    expect(method_exists(UserNotesModal::class, 'form'))->toBeTrue();
    expect(method_exists(UserNotesModal::class, 'render'))->toBeTrue();
});

test('user notes modal form renders correctly', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(UserNotesModal::class)
        ->assertSuccessful();
});
