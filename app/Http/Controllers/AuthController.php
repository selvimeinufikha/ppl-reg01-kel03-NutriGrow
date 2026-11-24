<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman pendaftaran akun baru (Register).
     */
    public function showRegister()
    {
        if (view()->exists('HalamanLogin.auth')) {
            return view('HalamanLogin.auth', ['initialMode' => 'register']);
        }

        return view('HalamanLogin.register', ['initialMode' => 'register']);
    }

    /**
     * Proses pendaftaran akun baru & simpan ke database.
     */
    public function register(Request $request)
    {
        // Validasi input sesuai ketentuan & keamanan
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem. Gunakan email lain atau masuk ke akun Anda.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'terms.accepted' => 'Anda harus menyetujui Syarat & Ketentuan serta Kebijakan Privasi NutriGrow.',
        ]);

        // Simpan data pengguna ke database
        $user = User::create([
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'password' => $validated['password'], // Otomatis di-hash oleh model User
        ]);

        // Login otomatis setelah berhasil mendaftar
        Auth::login($user);

        // Flash message sukses
        session()->flash('success_register', 'Selamat datang di NutriGrow, ' . $user->name . '! Akun Anda berhasil dibuat dan tersimpan aman di database.');

        // Arahkan ke dashboard pengguna jika ada, atau kembali dengan pesan sukses
        if (view()->exists('DashboardPengguna.index')) {
            return redirect()->route('dashboard.pengguna');
        }

        return redirect()->route('register')->with('success_modal', [
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->format('d M Y, H:i') . ' WIB',
        ]);
    }

    /**
     * API endpoint untuk validasi keunikan email secara real-time via AJAX.
     */
    public function checkEmail(Request $request)
    {
        $email = strtolower(trim($request->query('email', '')));

        if (empty($email)) {
            return response()->json([
                'status' => 'empty',
                'exists' => false,
                'message' => 'Email belum diisi.',
            ]);
        }

        $exists = User::where('email', $email)->exists();

        return response()->json([
            'status' => 'ok',
            'email' => $email,
            'exists' => $exists,
            'message' => $exists
                ? 'Email ini sudah terdaftar. Silakan gunakan email lain.'
                : 'Email tersedia dan dapat digunakan.',
        ]);
    }

    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        if (view()->exists('HalamanLogin.auth')) {
            return view('HalamanLogin.auth', ['initialMode' => 'login']);
        }

        return view('HalamanLogin.login', ['initialMode' => 'login']);
    }

    /**
     * Proses autentikasi login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var \App\Models\User $authUser */
            $authUser = Auth::user();

            // Jika yang login adalah Admin atau Nakes, tolak akses ke portal pengguna
            // dan arahkan ke portal admin. (PBI-016: Pemisahan akses Admin & User)
            if ($authUser->isStaffOrAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'login_error' => 'Akun Anda terdaftar sebagai Admin / Tenaga Kesehatan. Silakan masuk melalui Portal Admin.',
                ])->withInput($request->only('email', 'remember'))
                  ->with('redirect_admin', true);
            }

            session()->flash('success_login', 'Selamat datang kembali, ' . $authUser->name . '!');

            if (view()->exists('DashboardPengguna.index')) {
                return redirect()->route('dashboard.pengguna');
            }

            return redirect()->route('home');
        }

        return back()->withErrors([
            'login_error' => 'Email atau kata sandi yang Anda masukkan salah. Silakan periksa kembali.',
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * Tampilkan halaman permohonan Lupa Password.
     */
    public function showForgotPassword()
    {
        if (view()->exists('HalamanLogin.forgot-password')) {
            return view('HalamanLogin.forgot-password');
        }

        return view('HalamanLogin.forgot-password');
    }

    /**
     * Proses pengajuan link reset kata sandi & simpan token ke database.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Alamat email ini tidak terdaftar di sistem NutriGrow. Silakan periksa kembali.',
            ])->withInput();
        }

        // Generate token aman 64 karakter
        $token = Str::random(64);

        // Simpan / perbarui token di tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $email]);

        // Simpan modal sukses berisi data & link aktivasi prototipe
        return back()->with('reset_modal', [
            'name' => $user->name,
            'email' => $email,
            'token' => $token,
            'reset_url' => $resetUrl,
            'created_at' => now()->format('d M Y, H:i') . ' WIB',
        ]);
    }

    /**
     * Tampilkan halaman pengaturan ulang kata sandi (Reset Password).
     */
    public function showResetPassword(Request $request, $token)
    {
        $email = $request->query('email', '');
        $isInvalid = false;

        if ($token === 'demo' || $token === 'simulator') {
            $email = $email ?: 'ibu.anita@nutrigrow.id';
        } else {
            // Verifikasi keberadaan token di database
            $record = DB::table('password_reset_tokens')->where('email', $email)->first();

            if (!$record || !Hash::check($token, $record->token)) {
                $isInvalid = true;
            }
        }

        return view('HalamanLogin.reset-password', [
            'token' => $token,
            'email' => $email,
            'isInvalid' => $isInvalid,
        ]);
    }

    /**
     * Simpan kata sandi baru ke database & hapus token yang telah digunakan.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $email = strtolower(trim($request->email));

        // Dukungan mode simulasi / demo
        if ($request->token === 'simulator' || $request->token === 'demo') {
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => 'Pengguna NutriGrow', 'password' => $request->password]
            );
            $user->password = $request->password;
            $user->save();

            return redirect()->route('login')->with('success_reset', 'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru Anda.');
        }

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors([
                'email' => 'Token reset kata sandi tidak valid atau telah kedaluwarsa.',
            ]);
        }

        // Update password pengguna di tabel users
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = $request->password; // Otomatis di-hash oleh casts User
            $user->save();
        }

        // Hapus token yang sudah dipakai dari password_reset_tokens
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('login')->with('success_reset', 'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru Anda.');
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar.');
    }
}
