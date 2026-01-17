<?php

// app/Http/Middleware/CheckAdminAccess.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PanelAccess;

class FilamentPanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();

        if (! $user) {
            return redirect('/login')->with('error', 'Unauthorized access');
        }

$requestPath = $request->path();

$path = parse_url($requestPath, PHP_URL_PATH);

$segments = array_values(array_filter(explode('/', $path)));

if (($i = array_search('nds', $segments)) !== false) {
    $panelId = $segments[$i + 1] ?? null;
} else {
    $panelId = $segments[0] ?? null;
}

        logger()->info("requestPath:: {$requestPath}");

        logger()->info("User ID:: {$user->id} with Role:: {$user->role} accesesPanel:: '{$panelId}'");


        if (! $this->checkPanelAccess($panelId) && $panelId === 'app') {
            return redirect('/login')->with('error', 'Unauthorized access');
        }

        if (! $this->checkPanelAccess($panelId) && $panelId !== 'app') {
            abort(403, 'Not authorized to access ' . $panelId . ' panel');
        }

        return $next($request);
    }

    public function checkPanelAccess($panelId): bool
    {

        logger()->info("panelId:: {$panelId}");

        $user = Auth::user();

        if (! $user) {
            return false;
        }

        $panelAccess = PanelAccess::where('panel_id', $panelId)
            ->whereJsonContains('role_access', $user->role)
            ->where('is_active', true)
            ->first();

        return $panelAccess !== null;
    }
}
