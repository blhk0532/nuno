<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

final class DebugRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('livewire/upload-file')) {
            Log::info('Livewire Upload Request', [
                'url' => $request->fullUrl(),
                'scheme' => $request->getScheme(),
                'host' => $request->getHost(),
                'secure' => $request->secure(),
                'headers' => [
                    'x-forwarded-proto' => $request->header('x-forwarded-proto'),
                    'x-forwarded-host' => $request->header('x-forwarded-host'),
                    'x-forwarded-for' => $request->header('x-forwarded-for'),
                    'host' => $request->header('host'),
                ],
                'has_valid_signature' => $request->hasValidSignature(),
                'has_valid_signature_absolute_false' => $request->hasValidSignature(false),
            ]);
        }

        return $next($request);
    }
}
