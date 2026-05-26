<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegistService
{
    public function validateToken(string $token): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'X-Internal-Secret' => config('services.internal_secret'),
            ])->get(config('services.regist.url') . '/api/internal/validate-token');

            if ($response->successful()) {
                return $response->json();
            }
            
            Log::warning('Token validation failed: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Error validating token: ' . $e->getMessage());
            return null;
        }
    }

    public function lookupUserByRekening(string $nomorRekening): ?array
    {
        try {
            $response = Http::withHeaders([
                'X-Internal-Secret' => config('services.internal_secret'),
            ])->get(config('services.regist.url') . '/api/internal/user-by-rekening/' . $nomorRekening);

            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error looking up user by rekening: ' . $e->getMessage());
            return null;
        }
    }
}
