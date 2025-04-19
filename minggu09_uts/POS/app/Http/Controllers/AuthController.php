<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ------------------------------------- *jobsheet 07* -------------------------------------
    // JS7 - P1(authentication)
    public function login() {
        if (Auth::check()) {    //jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }

        return view('auth.login');
    }

    // JS7 - P1(authentication)
    public function postlogin(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');
    
            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil', 
                    'redirect' => url('/')
                ]);
            }
    
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }
    
        return redirect('login');
    }

    // JS7 - P1(authentication)
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}