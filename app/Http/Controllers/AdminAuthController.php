<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan halaman Masuk Admin / Portal Khusus Faskes & Nakes.
     * URL: /admin/login
     */
    public function showLoginForm()
    {
        // Selalu tampilkan halaman Login Admin saat URL /admin/login dibuka
        return view('HalamanAdmin.login');
    }

    /**
     * Proses autentikasi login khusus Admin & Tenaga Kesehatan.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email petugas / admin wajib diisi.',
            'email.email' => 'Format email petugas / admin tidak valid.',
            'password.required' => 'Kata sandi akun petugas wajib diisi.',
        ]);

        $remember = $request->boolean('remember');
        $email = strtolower(trim($credentials['email']));
        $password = $credentials['password'];

        // Cek login via Auth::attempt
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            $request->session()->regenerate();

            /** @var User $authUser */
            $authUser = Auth::user();

            // Validasi hak akses faskes / admin
            if (method_exists($authUser, 'isStaffOrAdmin') && !$authUser->isStaffOrAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'login_error' => 'Akun ini terdaftar sebagai akun keluarga/orang tua. Silakan masuk melalui halaman login pengguna umum.',
                ])->withInput($request->only('email'));
            }

            // Flash notifikasi sukses
            session()->flash('success_admin_login', 'Selamat datang, ' . $authUser->name . '! Anda berhasil masuk ke Dashboard Admin NutriGrow.');

            // Arahkan LANGSUNG ke Dashboard Admin (URL: /admin/dashboard)
            return redirect()->route('admin.dashboard');
        }

        // Dukungan kredensial default untuk demo praktikum
        if (in_array($email, ['admin@nutrigrow.id', 'petugas@puskesmas.go.id']) && $password === 'admin123') {
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $email === 'admin@nutrigrow.id' ? 'dr. Sarah Nakes (Admin Faskes)' : 'Bidan Nurul Fitriah, S.Tr.Keb',
                    'password' => Hash::make('admin123'),
                    'role' => $email === 'admin@nutrigrow.id' ? 'admin' : 'nakes',
                    'faskes_name' => 'Puskesmas Kecamatan Tebet & NutriGrow Health',
                    'nip_str' => 'STR-19880412-2023-019',
                ]
            );

            Auth::login($user, $remember);
            $request->session()->regenerate();

            session()->flash('success_admin_login', 'Selamat datang, ' . $user->name . '! Anda berhasil masuk ke Dashboard Admin NutriGrow.');

            // Arahkan LANGSUNG ke Dashboard Admin (URL: /admin/dashboard)
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'login_error' => 'Email petugas atau kata sandi salah. Pastikan Anda menggunakan akun resmi faskes/nakes.',
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * Proses logout admin & tenaga kesehatan.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success_logout', 'Anda telah berhasil keluar dari Portal Admin & Tenaga Kesehatan.');
    }
}
