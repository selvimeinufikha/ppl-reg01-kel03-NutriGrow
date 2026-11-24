<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware CheckRole
 *
 * Memastikan pengguna yang login memiliki role yang sesuai.
 * Digunakan untuk memisahkan akses antara:
 * - Pengguna / Orang Tua (role: user)
 * - Admin & Tenaga Kesehatan (role: admin, nakes)
 *
 * PBI-016 / F-06: Pengelolaan Pengukuran dan Status Gizi Anak
 * Acceptance Criteria: Hanya Admin/Nakes yang dapat mengakses portal admin.
 */
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles   Satu atau beberapa role yang diizinkan (mis: 'admin', 'nakes', 'user')
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = Auth::user();

        // Pastikan pengguna sudah login
        if (! $user) {
            // Tentukan halaman login yang tepat sesuai URL yang diakses
            if ($request->is('admin/*') || $request->is('admin')) {
                return redirect()->route('admin.login')
                    ->with('error', 'Silakan masuk menggunakan akun petugas / admin faskes.');
            }
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Periksa apakah role user termasuk dalam daftar $roles yang diizinkan
        if (! in_array($user->role, $roles)) {
            // Jika pengguna biasa (role: user) mencoba akses portal admin
            if (in_array($user->role, ['user']) && ($request->is('admin/*') || $request->is('admin'))) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')
                    ->withErrors([
                        'login_error' => 'Akun Anda terdaftar sebagai akun keluarga/orang tua. Silakan gunakan halaman login pengguna umum.',
                    ]);
            }

            // Jika admin/nakes mencoba akses portal pengguna biasa
            if (in_array($user->role, ['admin', 'nakes']) && ! $request->is('admin/*')) {
                return redirect()->route('admin.dashboard')
                    ->with('info', 'Anda login sebagai ' . ucfirst($user->role) . '. Diarahkan ke dashboard admin.');
            }

            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}

