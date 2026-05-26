<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InternalSecretMiddleware
{
    /**
     * Validasi X-Internal-Secret header untuk akses internal antar service.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secret = $request->header('X-Internal-Secret');

        if (! $secret || $secret !== config('services.internal_secret')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Invalid or missing internal secret key.',
            ], 401);
        }

        return $next($request);
    }
}
