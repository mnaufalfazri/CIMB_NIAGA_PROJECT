<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InternalApiController extends Controller
{
    /**
     * Validasi token Sanctum dari service lain.
     * GET /api/internal/validate-token
     * Header: X-Internal-Secret (divalidasi oleh middleware)
     * Header: Authorization: Bearer {token}
     */
    public function validateToken(Request $request)
    {
        try {
            // Token sudah divalidasi oleh auth:sanctum middleware
            $user = $request->user();

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token tidak valid atau sudah kadaluarsa.',
                ], 401);
            }

            return response()->json([
                'id'              => $user->id,
                'name'            => $user->name,
                'email'           => $user->email,
                'nomor_rekening'  => $user->nomor_rekening,
                'role'            => $user->role,
                'status'          => $user->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memvalidasi token: ' . $e->getMessage(),
            ], 503);
        }
    }

    /**
     * Cari user berdasarkan nomor rekening.
     * GET /api/internal/user-by-rekening/{nomor_rekening}
     * Header: X-Internal-Secret (divalidasi oleh middleware)
     */
    public function userByRekening(string $nomorRekening)
    {
        try {
            $user = User::where('nomor_rekening', $nomorRekening)->first();

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User dengan nomor rekening tersebut tidak ditemukan.',
                ], 404);
            }

            return response()->json([
                'id'             => $user->id,
                'name'           => $user->name,
                'email'          => $user->email,
                'nomor_rekening' => $user->nomor_rekening,
                'role'           => $user->role,
                'status'         => $user->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Service tidak dapat diakses: ' . $e->getMessage(),
            ], 503);
        }
    }

    /**
     * Login API - kembalikan token Sanctum untuk service lain.
     * POST /api/auth/login
     * Body: { email, password }
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah.',
                ], 401);
            }

            if ($user->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun tidak aktif.',
                ], 403);
            }

            // Hapus token lama, buat yang baru
            $user->tokens()->delete();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'token'   => $token,
                'user'    => [
                    'id'             => $user->id,
                    'name'           => $user->name,
                    'email'          => $user->email,
                    'nomor_rekening' => $user->nomor_rekening,
                    'role'           => $user->role,
                    'status'         => $user->status,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login gagal: ' . $e->getMessage(),
            ], 503);
        }
    }
}
