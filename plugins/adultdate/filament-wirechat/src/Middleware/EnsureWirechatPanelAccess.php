<?php

namespace Adultdate\Wirechat\Middleware;

use Adultdate\Wirechat\Exceptions\NoPanelProvidedException;
use Adultdate\Wirechat\PanelRegistry;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class EnsureWirechatPanelAccess
{
    public function __construct(protected PanelRegistry $panelRegistry) {}

    /**
     * @throws ContainerExceptionInterface
     * @throws NoPanelProvidedException
     * @throws NotFoundExceptionInterface
     */
    public function handle($request, Closure $next, string $panelId): mixed
    {
        $panel = $this->panelRegistry->get($panelId);

        if (! $panel) {
            abort(404, 'Panel not found.');
        }

        $user = Auth::user();

        if (! $user || ! Auth::canAccessWirechatPanel($panel)) {
            abort(404);
        }

        return $next($request);
    }
}
