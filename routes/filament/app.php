<?php

declare(strict_types=1);

use App\Filament\App\Pages\AppDashboard;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'verified'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get('{username}', function ($username) {
            // Optionally, you can check if the username exists and matches the logged-in user
            if (auth()->user()?->username !== $username) {
                abort(403);
            }

            return app(AppDashboard::class)->render();
        })->name('dashboard.user');
    });
