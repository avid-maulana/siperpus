<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required',
        ]);

        $user = \App\Models\User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'Username tidak ditemukan.',
            ]);
        }

        // Gunakan password_verify() agar bisa membaca hash $2a$
        if (!password_verify($request->password, $user->password)) {
            return back()->withErrors([
                'username' => 'Username atau Password salah.',
            ]);
        }

        if ((int) $request->captcha !== session('captcha_hasil')) {
            return back()->withErrors(['captcha' => 'Jawaban captcha salah.']);
        }

        // Login manual jika password cocok
        if ($user->level == 6 || ($user->level >= 1 && $user->level <= 12)) {
            Auth::login($user);
            $request->session()->regenerate();

            if ($user->level == 6) {
                return redirect()->intended('/library');
            } else {
                return redirect()->intended('/');
            }
        } else {
            return back()->withErrors([
                'username' => 'Level user tidak valid.',
            ]);
        }
    }

    public function username()
    {
        return 'username';
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
