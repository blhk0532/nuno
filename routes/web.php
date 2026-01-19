<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CalendarBookingController;
use App\Http\Controllers\Api\CalendarDataController;
use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\CalendarResourceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserEmailResetNotification;
use App\Http\Controllers\UserEmailVerificationNotificationController;
use App\Http\Controllers\UserPasswordController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserTwoFactorAuthenticationController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use Inertia\Inertia;

// Route::get('/', fn () => Inertia::render('welcome'))->name('home');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('api/calendar')->group(function (): void {
    Route::get('bookings/public', [CalendarBookingController::class, 'publicIndex']);
});

Route::middleware(['web', 'inertia', 'auth', 'verified'])->group(function (): void {
    Route::get('dashboard', fn () => Inertia::render('dashboard'))->name('dashboard');
    Route::get('app', fn () => Inertia::render('app'))->name('app');
    Route::get('bokningar', fn () => Inertia::render('bokningar'))->name('bokningar');
});

Route::middleware(['web', 'inertia', 'auth', 'verified'])->group(function (): void {
    Route::get('calendar', fn () => Inertia::render('calendar'))->name('calendar');
    Route::get('calendars', fn () => Inertia::render('calendars'))->name('calendars');
    Route::get('calendar-one', fn () => Inertia::render('calendar-one'))->name('calendar-one');
    Route::get('calendar-two', fn () => Inertia::render('calendar-two'))->name('calendar-two');
    Route::get('calendar-multi', fn () => Inertia::render('calendar-multi'))->name('calendar-multi');
    Route::get('calendar-example', fn () => Inertia::render('calendar-example'))->name('calendar-example');
    Route::get('big-calendar', fn () => Inertia::render('big-calendar'))->name('big-calendar');
    Route::get('full-calendar', fn () => Inertia::render('full-calendar'))->name('full-calendar');
    Route::get('shadcn-event-calendar', fn () => Inertia::render('shadcn-event-calendar'))->name('shadcn-event-calendar');
    Route::get('booking-calendar', fn () => Inertia::render('booking-calendar'))->name('booking-calendar');
    Route::get('calendar/events', CalendarEventController::class)->name('calendar.events');
    Route::get('calendar/resources', CalendarResourceController::class)->name('calendar.resources');

    // API routes for calendar booking operations
    Route::prefix('api/calendar')->group(function (): void {
        Route::get('bookings', [CalendarBookingController::class, 'index']);
        Route::post('bookings', [CalendarBookingController::class, 'store']);
        Route::put('bookings/{booking}', [CalendarBookingController::class, 'update']);
        Route::delete('bookings/{booking}', [CalendarBookingController::class, 'destroy']);
        Route::patch('bookings/{booking}/move', [CalendarBookingController::class, 'move']);
        Route::patch('bookings/{booking}/resize', [CalendarBookingController::class, 'resize']);

        // API routes for calendar data
        Route::get('clients', [CalendarDataController::class, 'clients']);
        Route::post('clients', [CalendarDataController::class, 'store']);
        Route::get('services', [CalendarDataController::class, 'services']);
        Route::get('locations', [CalendarDataController::class, 'locations']);
        Route::get('service-users', [CalendarDataController::class, 'serviceUsers']);
        Route::get('calendars', [CalendarDataController::class, 'calendars']);
        Route::get('categories', [CalendarDataController::class, 'categories']);
        Route::get('stats', [CalendarDataController::class, 'bookingStats']);
    });
});

Route::middleware(['web', 'inertia', 'auth'])->group(function (): void {
    // User...
    Route::delete('user', [UserController::class, 'destroy'])->name('user.destroy');

    // User Profile...
    Route::redirect('settings', '/settings/profile');
    Route::get('settings/profile', [UserProfileController::class, 'edit'])->name('user-profile.edit');
    Route::patch('settings/profile', [UserProfileController::class, 'update'])->name('user-profile.update');

    // User Password...
    Route::get('settings/password', [UserPasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [UserPasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.update');

    // Appearance...
    Route::get('settings/appearance', fn () => Inertia::render('appearance/update'))->name('appearance.edit');

    // User Two-Factor Authentication...
    Route::get('settings/two-factor', [UserTwoFactorAuthenticationController::class, 'show'])->name('two-factor.show');
});

Route::middleware('guest')->group(function (): void {
    // User...
    Route::get('register', [UserController::class, 'create'])->name('register');
    Route::post('register', [UserController::class, 'store'])->name('register.store');

    // User Password...
    Route::get('reset-password/{token}', [UserPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [UserPasswordController::class, 'store'])->name('password.store');

    // User Email Reset Notification...
    Route::get('forgot-password', [UserEmailResetNotification::class, 'create'])->name('password.request');
    Route::post('forgot-password', [UserEmailResetNotification::class, 'store'])->name('password.email');

    // Session...
    Route::get('login', [SessionController::class, 'create'])->name('login');
    Route::post('login', [SessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    // User Email Verification...
    Route::get('verify-email', [UserEmailVerificationNotificationController::class, 'create'])->name('verification.notice');
    Route::post('email/verification-notification', [UserEmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // User Email Verification...
    Route::get('verify-email/{id}/{hash}', [UserEmailVerificationNotificationController::class, 'update'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Session...
    Route::post('logout', [SessionController::class, 'destroy'])->name('logout');

    // Back-compat: provide named routes for the chat dashboard so Filament
    // navigation does not throw when a page is referenced but not registered.
    Route::get('filament/app/chat-dashboard', function () {
        // This is a safe fallback; when the actual chat dashboard page is available
        // Filament will provide the correct route and override this. For now we
        // redirect to the app dashboard to avoid exceptions in the sidebar.
        return redirect()->route('dashboard');
    })->name('filament.app.pages.chat-dashboard');

    Route::get('filament/admin/chat-dashboard', function () {
        // Fallback for the admin panel chat dashboard nav item. Redirect to
        // the admin dashboard to keep navigation stable.
        return redirect()->route('dashboard');
    })->name('filament.admin.pages.chat-dashboard');
});
