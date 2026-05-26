<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\RegistService;

class ValidateServiceToken
{
    protected $registService;

    public function __construct(RegistService $registService)
    {
        $this->registService = $registService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->query('token') ?? $request->bearerToken() ?? session('api_token');

        $loginUrl = config('services.regist.url') . '/login';

        if (!$token) {
            if ($request->header('X-Inertia')) {
                return \Inertia\Inertia::location($loginUrl);
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect($loginUrl);
        }

        // Validate via RegistService
        $user = $this->registService->validateToken($token);

        if (!$user) {
            session()->forget(['api_token', 'user']);
            if ($request->header('X-Inertia')) {
                return \Inertia\Inertia::location($loginUrl);
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect($loginUrl)->with('error', 'Sesi telah habis, silakan login kembali.');
        }

        // Save token and user info to session
        session(['api_token' => $token, 'user' => $user]);

        return $next($request);
    }
}
