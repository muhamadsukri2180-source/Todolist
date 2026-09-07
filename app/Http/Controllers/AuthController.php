<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman pendaftaran akun baru.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('todos.index');
        }

        return view('auth.register');
    }

    /**
     * Memproses pendaftaran akun baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:50|alpha_dash|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan, silakan pilih yang lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda strip, dan garis bawah.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal berjumlah 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Jika username tidak diisi, buat otomatis dari nama atau bagian awal email
        $username = $validated['username'] ?? null;
        if (empty($username)) {
            $baseUsername = Str::slug(explode('@', $validated['email'])[0], '');
            $username = $baseUsername;
            $counter = 1;
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'username' => strtolower($username),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('todos.index')->with('success', "Pendaftaran berhasil. Selamat datang di TaskFlow, {$user->name}. Simpan username Anda untuk masuk: {$user->username}");
    }

    /**
     * Menampilkan halaman masuk akun.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('todos.index');
        }

        return view('auth.login');
    }

    /**
     * Memproses autentikasi masuk akun menggunakan username & password.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $usernameInput = trim($credentials['username']);
        
        // Memeriksa login berdasarkan username (atau email jika pengguna memasukkan email)
        $loginType = filter_var($usernameInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $attempt = Auth::attempt([
            $loginType => $usernameInput,
            'password' => $credentials['password'],
        ], $request->boolean('remember'));

        if ($attempt) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.users'))->with('success', 'Selamat datang, Administrator TaskFlow.');
            }

            return redirect()->intended(route('todos.index'))->with('success', 'Berhasil masuk. Selamat datang kembali!');
        }

        return back()->withErrors([
            'username' => 'Username atau kata sandi yang Anda masukkan tidak cocok.',
        ])->onlyInput('username');
    }

    /**
     * Keluar dari sesi akun saat ini.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'Anda telah berhasil keluar dari akun.');
    }
}
