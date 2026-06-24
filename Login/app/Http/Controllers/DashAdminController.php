<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'nasabah');

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['active', 'banned'])) {
            $query->where('status', $request->status);
        }

        // Search by name, email, or nomor_rekening
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nomor_rekening', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('dashboard.DashAdmin', compact('users'));
    }

    public function toggleBan(User $user)
    {
        // Hanya nasabah yang bisa di-ban/unban, bukan admin
        if ($user->role !== 'nasabah') {
            abort(403);
        }

        $user->status = ($user->status === 'banned') ? 'active' : 'banned';
        $user->save();

        $action = ($user->status === 'banned') ? 'di-banned' : 'di-aktifkan kembali';

        return back()->with('success', "Nasabah {$user->name} berhasil {$action}.");
    }
}
