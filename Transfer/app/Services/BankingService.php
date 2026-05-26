<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BankingService
{
    public function validateAccount(string $nomorRekening): ?array
    {
        try {
            $response = Http::withHeaders([
                'X-Internal-Secret' => config('services.internal_secret'),
            ])->get(config('services.banking.url') . '/api/internal/validate-account/' . $nomorRekening);

            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error validating account: ' . $e->getMessage());
            return null;
        }
    }

    public function checkBalance(string $nomorRekening): ?array
    {
        try {
            $response = Http::withHeaders([
                'X-Internal-Secret' => config('services.internal_secret'),
            ])->get(config('services.banking.url') . '/api/internal/balance/' . $nomorRekening);

            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error checking balance: ' . $e->getMessage());
            return null;
        }
    }

    public function debit(array $data): array
    {
        try {
            $response = Http::withHeaders([
                'X-Internal-Secret' => config('services.internal_secret'),
            ])->post(config('services.banking.url') . '/api/internal/debit', $data);

            if ($response->successful()) {
                return $response->json();
            }
            
            $errorData = $response->json();
            return [
                'success' => false,
                'message' => $errorData['message'] ?? 'Debit failed'
            ];
        } catch (\Exception $e) {
            Log::error('Error debiting account: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage()
            ];
        }
    }

    public function credit(array $data): array
    {
        try {
            $response = Http::withHeaders([
                'X-Internal-Secret' => config('services.internal_secret'),
            ])->post(config('services.banking.url') . '/api/internal/credit', $data);

            if ($response->successful()) {
                return $response->json();
            }
            
            $errorData = $response->json();
            return [
                'success' => false,
                'message' => $errorData['message'] ?? 'Credit failed'
            ];
        } catch (\Exception $e) {
            Log::error('Error crediting account: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage()
            ];
        }
    }
}
