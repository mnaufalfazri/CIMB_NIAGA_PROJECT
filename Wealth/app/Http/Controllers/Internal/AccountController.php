<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\CreditRequest;
use App\Http\Requests\DebitRequest;
use App\Models\FailedTransaction;
use App\Services\WealthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AccountController extends Controller
{
    public function __construct(
        private readonly WealthService $wealthService
    ) {}

    /**
     * SRS-BNK-003: Auto-Create Account
     * Called by Registration Service when admin approves a new user.
     *
     * POST /api/internal/accounts
     */
    public function store(CreateAccountRequest $request): JsonResponse
    {
        try {
            $account = $this->wealthService->createAccountForUser($request->validated());

            return response()->json([
                'success'        => true,
                'message'        => 'Akun berhasil dibuat.',
                'nomor_rekening' => $account->nomor_rekening,
                'balance'        => (float) $account->balance,
                'account_type'   => $account->account_type,
            ], 201);
        } catch (Throwable $e) {
            $this->logFailedTransaction($request->input('reference_id', 'INIT-ERR-' . time()), $request->all(), $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * SRS-BNK-004: Check Balance
     *
     * GET /api/internal/balance/{nomor_rekening}
     */
    public function balance(string $nomorRekening): JsonResponse
    {
        $result = $this->wealthService->checkBalance($nomorRekening);

        if (! $result) {
            return response()->json([
                'success' => false,
                'message' => 'Rekening tidak ditemukan atau tidak aktif.',
            ], 404);
        }

        return response()->json([
            'success'        => true,
            'nomor_rekening' => $result['nomor_rekening'],
            'balance'        => $result['balance'],
            'currency'       => $result['currency'],
        ]);
    }

    /**
     * SRS-BNK-005: Validate Account
     *
     * GET /api/internal/validate-account/{nomor_rekening}
     */
    public function validate(string $nomorRekening): JsonResponse
    {
        $result = $this->wealthService->validateAccount($nomorRekening);

        return response()->json([
            'success'        => true,
            'exists'         => $result['exists'],
            'name'           => $result['name'],
            'nomor_rekening' => $result['nomor_rekening'],
            'status'         => $result['status'] ?? null,
        ]);
    }

    /**
     * SRS-BNK-006: Debit Account
     *
     * POST /api/internal/debit
     */
    public function debit(DebitRequest $request): JsonResponse
    {
        try {
            $result = $this->wealthService->debitAccount($request->validated());

            return response()->json([
                'success'       => true,
                'balance_after' => $result['balance_after'],
            ]);
        } catch (Throwable $e) {
            $httpCode = (int) $e->getCode();
            $httpCode = in_array($httpCode, [400, 404, 422]) ? $httpCode : 500;

            if ($httpCode === 500) {
                $this->logFailedTransaction($request->input('reference_id'), $request->all(), $e->getMessage());
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $httpCode);
        }
    }

    /**
     * SRS-BNK-007: Credit Account
     *
     * POST /api/internal/credit
     */
    public function credit(CreditRequest $request): JsonResponse
    {
        try {
            $result = $this->wealthService->creditAccount($request->validated());

            return response()->json([
                'success'       => true,
                'balance_after' => $result['balance_after'],
            ]);
        } catch (Throwable $e) {
            $httpCode = (int) $e->getCode();
            $httpCode = in_array($httpCode, [400, 404, 422]) ? $httpCode : 500;

            if ($httpCode === 500) {
                $this->logFailedTransaction($request->input('reference_id'), $request->all(), $e->getMessage());
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $httpCode);
        }
    }

    /**
     * Log a failed transaction to the dead-letter table.
     */
    private function logFailedTransaction(string $referenceId, array $payload, string $errorMessage): void
    {
        try {
            FailedTransaction::updateOrCreate(
                ['reference_id' => $referenceId],
                [
                    'payload'       => $payload,
                    'error_message' => $errorMessage,
                    'retry_count'   => 0,
                    'status'        => 'pending',
                ]
            );
        } catch (Throwable) {
            // Silently fail — logging should never break the response chain
        }
    }
}
