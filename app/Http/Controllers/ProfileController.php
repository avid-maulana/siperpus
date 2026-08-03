<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        if (!password_verify($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah.',
            ]);
        }

        $newPassword = Hash::make($request->password);
        $user->password = $newPassword;
        $user->pwd_hash = $newPassword;
        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
