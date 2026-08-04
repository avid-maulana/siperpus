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
            'captcha'  => 'required',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Cari User
    |--------------------------------------------------------------------------
    */
        $user = \App\Models\User::where('username', $request->username)->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'username' => 'Username tidak ditemukan.',
                ])
                ->withInput($request->only('username'));
        }

        /*
    |--------------------------------------------------------------------------
    | Validasi Password
    |--------------------------------------------------------------------------
    */
        if (!password_verify($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'username' => 'Username atau Password salah.',
                ])
                ->withInput($request->only('username'));
        }

        /*
    |--------------------------------------------------------------------------
    | Validasi Captcha
    |--------------------------------------------------------------------------
    */
        if ((int) $request->captcha !== (int) session('captcha_hasil')) {
            return back()
                ->withErrors([
                    'captcha' => 'Jawaban captcha salah.',
                ])
                ->withInput($request->only('username'));
        }

        /*
    |--------------------------------------------------------------------------
    | Validasi Level
    |--------------------------------------------------------------------------
    */
        if ($user->level < 1 || $user->level > 12) {
            return back()
                ->withErrors([
                    'username' => 'Level user tidak valid.',
                ])
                ->withInput($request->only('username'));
        }

        /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */
        Auth::login($user);

        $request->session()->regenerate();

        /*
    |--------------------------------------------------------------------------
    | Redirect Home
    |--------------------------------------------------------------------------
    */
        return redirect()->route('home');
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
