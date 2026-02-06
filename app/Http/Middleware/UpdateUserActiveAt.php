<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserActiveStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

final class UpdateUserActiveAt
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        $user = Auth::user();

        if (! $user) {
            return;
        }

        $cacheKey = "user_last_active_{$user->id}";

        // Only update every 5 minutes to reduce database load
        if (Cache::has($cacheKey)) {
            return;
        }

        // Update active_at and ensure status is not offline
        // Use saveQuietly to avoid triggering observers/activity logs for this frequent update
        $user->forceFill([
            'active_at' => now(),
            'active_status' => $user->active_status === UserActiveStatus::Offline
                ? UserActiveStatus::Online
                : ($user->active_status ?? UserActiveStatus::Online),
        ])->saveQuietly();

        Cache::put($cacheKey, true, now()->addMinutes(5));
    }
}
