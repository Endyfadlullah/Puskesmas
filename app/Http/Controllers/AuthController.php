<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Poli;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email_or_ktp' => 'required|string',
            'password' => 'required',
        ]);

        $emailOrKtp = $request->email_or_ktp;
        $password = $request->password;

        // First, try to find admin by username
        $admin = Admin::where('username', $emailOrKtp)->first();

        if ($admin && Hash::check($password, $admin->password)) {
            Auth::guard('admin')->login($admin, $request->remember);
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard')->with('success', 'Selamat datang, Admin!');
        }

        // If not admin, try to find user by nama (username) or no_ktp
        $user = User::where('nama', $emailOrKtp)
            ->orWhere('no_ktp', $emailOrKtp)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $request->remember);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Selamat datang, ' . $user->nama . '!');
        }

        // If neither admin nor user found, return error
        return back()->withErrors([
            'email_or_ktp' => 'Username/Nama/No KTP atau password salah.',
        ])->withInput($request->only('email_or_ktp'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'required|string|max:20',
            'no_ktp' => 'required|string|size:16|unique:users|regex:/^[0-9]+$/',
            'pekerjaan' => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'no_ktp.size' => 'Nomor KTP harus tepat 16 digit.',
            'no_ktp.regex' => 'Nomor KTP hanya boleh berisi angka.',
            'no_ktp.unique' => 'Nomor KTP sudah terdaftar.',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'no_ktp' => $request->no_ktp,
            'pekerjaan' => $request->pekerjaan,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request)
    {
        // Check if admin is logged in
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda berhasil logout!');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:50',
        ]);

        $nama = $request->nama;
        $noKtp = $request->no_ktp;

        // Cari user berdasarkan nama dan no_ktp
        $user = User::where('nama', $nama)
            ->where('no_ktp', $noKtp)
            ->first();

        if ($user) {
            // Jika kedua data benar, simpan user_id di session dan arahkan ke reset password
            $request->session()->put('reset_user_id', $user->id);
            return redirect()->route('reset-password')->with('success', 'Verifikasi berhasil! Silakan masukkan password baru.');
        } else {
            // Jika salah satu atau keduanya salah, berikan pesan error
            return back()->withErrors([
                'nama' => 'Nama atau nomor KTP tidak ditemukan. Silakan hubungi admin untuk verifikasi data.',
            ])->withInput($request->only('nama', 'no_ktp'));
        }
    }

    public function showResetPassword(Request $request)
    {
        // Cek apakah ada user_id di session
        if (!$request->session()->has('reset_user_id')) {
            return redirect()->route('forgot-password')->with('error', 'Sesi verifikasi tidak valid. Silakan verifikasi ulang.');
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cek apakah user_id di session sama dengan yang dikirim
        if ($request->session()->get('reset_user_id') != $request->user_id) {
            return redirect()->route('forgot-password')->with('error', 'Sesi verifikasi tidak valid. Silakan verifikasi ulang.');
        }

        $user = User::find($request->user_id);

        if (!$user) {
            return redirect()->route('forgot-password')->with('error', 'User tidak ditemukan.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus session reset_user_id
        $request->session()->forget('reset_user_id');

        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
