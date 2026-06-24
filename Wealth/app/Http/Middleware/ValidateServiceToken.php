<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Account;
use App\Models\User;
use App\Services\WealthService;
use Symfony\Component\HttpFoundation\Response;

class ValidateServiceToken
{
    /**
     * Handle an incoming request.
     * Inertia sends X-Inertia header + wantsJson() — we must ALWAYS redirect,
     * never return a plain JSON 401, so Inertia can handle the redirect properly.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tokenFromQuery = $request->query('token');
        $currentToken = session('api_token');
        $token = $tokenFromQuery ?? $currentToken;

        Log::info("ValidateServiceToken running. Token: " . ($token ?: 'NULL'));

        if ($token) {
            // If the token changed from query string, force re-validation
            if ($tokenFromQuery && $tokenFromQuery !== $currentToken) {
                session(['api_token' => $token]);
                Auth::logout();
            } elseif ($tokenFromQuery) {
                session(['api_token' => $token]);
            }

            // If not logged in locally yet, validate with the Login microservice
            if (!Auth::check()) {
                try {
                    $response = Http::withHeaders([
                        'Authorization'    => 'Bearer ' . $token,
                        'X-Internal-Secret' => config('services.internal_secret'),
                    ])->get(config('services.regist.url') . '/api/internal/validate-token');

                    if ($response->successful()) {
                        $userData  = $response->json();
                        $localUser = User::where('email', $userData['email'])->first();

                        if (!$localUser) {
                            // User baru registrasi: belum ada di DB Wealth, buat otomatis
                            Log::info('ValidateServiceToken: User not found locally, creating from Login service data: ' . $userData['email']);
                            $localUser = User::create([
                                'name'     => $userData['name'],
                                'email'    => $userData['email'],
                                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(32)),
                            ]);

                            // Buat Account untuk user baru jika belum ada
                            if ($localUser && !empty($userData['nomor_rekening'])) {
                                $accountExists = Account::where('user_id', $localUser->id)->exists();
                                if (!$accountExists) {
                                    Log::info('ValidateServiceToken: Creating account for new user: ' . $localUser->email);
                                    app(WealthService::class)->createAccountForUser([
                                        'user_id'        => $localUser->id,
                                        'user_name'      => $localUser->name,
                                        'nomor_rekening' => $userData['nomor_rekening'],
                                        'account_type'   => 'saving',
                                    ]);
                                }
                            }
                        }

                        if ($localUser) {
                            Log::info('ValidateServiceToken: Logging in user ' . $localUser->email);
                            Auth::login($localUser);
                        } else {
                            Log::warning('ValidateServiceToken: Failed to create/find local user for email: ' . $userData['email']);
                            session()->forget('api_token');
                        }
                    } else {
                        Log::warning('ValidateServiceToken: Token validation failed: ' . $response->body());
                        session()->forget('api_token');
                    }
                } catch (\Exception $e) {
                    Log::error('ValidateServiceToken: Error connecting to Login service: ' . $e->getMessage());
                }
            }
        }

        // If still not authenticated, always redirect
        if (!Auth::check()) {
            $loginUrl = config('services.regist.url', 'http://localhost:8001') . '/login';
            
            if ($request->header('X-Inertia')) {
                return \Inertia\Inertia::location($loginUrl);
            }
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            return redirect($loginUrl)->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
