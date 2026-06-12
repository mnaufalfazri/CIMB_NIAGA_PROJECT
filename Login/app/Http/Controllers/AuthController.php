<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|max:50'
        ]);
        if(Auth::attempt($request->only('email','password'), $request->remember)){
            $user = Auth::user();
            if($user->role == 'admin') return redirect('/DashAdmin');

            // Issue Sanctum token untuk integrasi dengan Wealth/Banking service
            $user->tokens()->delete();
            $token = $user->createToken('api-token')->plainTextToken;

            // Redirect ke Wealth service (dashboard) dengan token
            $wealthUrl = config('services.banking.url', 'http://localhost:8002');
            return redirect($wealthUrl . '/dashboard?token=' . $token);
        }
        return back()->with('failed', 'Email atau password salah');
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|min:3|max:50',
            'nomor_rekening' => 'required|digits:13|numeric',
            'email' => 'required|email|max:50',
            'password' => 'required|max:50|min:8',
            'confirm_password' => 'required|max:50|min:8|same:password',
        ]);
        $request['status'] = "active";
        $user = User::create($request->all());
        Auth::login($user);

        // Issue token untuk nasabah baru, redirect ke Wealth dashboard
        $token = $user->createToken('api-token')->plainTextToken;
        $wealthUrl = config('services.banking.url', 'http://localhost:8002');
        return redirect($wealthUrl . '/dashboard?token=' . $token);
    }

    public function logout(){
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
        }
        Auth::logout($user);
        return redirect('/');
    }
}

