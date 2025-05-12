<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Method for handling manual registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'ktp_number' => 'required|string',
            'phone' => 'required|string',
        ]);

        $password = Hash::make($request->password);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $password,
            'phone' => $request->phone,
            'ktp_number' => $request->ktp_number,
            'role' => 'user',  // default role
            'google_id' => null,
            'created_at' => now(),
        ]);

        return redirect()->route('main')->with('success', 'Registration successful!');
    }

    // Method for handling manual login
    public function login(Request $request)
    {
        // Validasi input email dan password
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6', // Sesuaikan panjang minimal password
        ]);

        // Mencoba untuk login
        $credentials = $request->only('email', 'password');

        // Memeriksa apakah kredensial valid
        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            $redirect = ($user->role === 'admin' || $user->role === 'superadmin')
                ? route('main')
                : route('main');

            return response()->json(['success' => true, 'redirect' => $redirect]);
        }

        // Cek apakah email ditemukan
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'email' => 'Email tidak ditemukan'
                ]
            ], 422); // Kode status 422 untuk validasi error
        }

        // Jika password salah
        return response()->json([
            'success' => false,
            'errors' => [
                'password' => 'Password salah'
            ]
        ], 422); // Kode status 422 untuk validasi error
    }

    // Method for handling Google login/registration
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if the user already exists
        $user = User::where('google_id', $googleUser->getId())->first();

        // Jika user belum ada, buat user baru
        if (!$user) {
            // Tentukan base username dari nama pengguna Google
            $baseUsername = Str::slug($googleUser->getName());  // Menggunakan nama pengguna Google untuk base username

            // Cek apakah username sudah ada, dan jika ada, tambahkan angka
            $username = $this->generateUniqueUsername($baseUsername);

            // Buat pengguna baru dengan username yang unik
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'username' => $username,  // Username yang valid
                'password' => Hash::make(Str::random(16)), // Password acak karena login menggunakan Google
                'google_id' => $googleUser->getId(),
                'role' => 'user',  // Default role
                'created_at' => now(),
            ]);
        }

        // Login the user
        auth()->login($user);

        // If phone and KTP are not filled, redirect to profile update form
        if (empty($user->phone) || empty($user->ktp_number)) {
            return redirect()->route('main', ['showUpdateModal' => true]);
        }

        // Redirect to the home page or dashboard based on the role
        if ($user->role == 'admin' || $user->role == 'superadmin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('main');
    }

    private function generateUniqueUsername($baseUsername)
    {
        // Hilangkan spasi dan tanda minus (-), ganti dengan string tanpa spasi
        $username = str_replace([' ', '-'], '', $baseUsername);

        // Tambahkan angka random di belakang username untuk keunikan
        $username .= rand(1000, 9999);

        // Cek apakah username sudah ada di database
        while (User::where('username', $username)->exists()) {
            // Jika username sudah ada, tambahkan angka acak lainnya
            $username = str_replace(' ', '', $baseUsername) . rand(1000, 9999);
        }

        return $username;
    }

    // Method for handling logout
    public function logout()
    {
        // Logout pengguna
        auth()->logout(); // Logout pengguna

        return redirect()->route('main')->with('message', 'Logout berhasil!'); // Redirect ke halaman utama setelah logout
    }
}
