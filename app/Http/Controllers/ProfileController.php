<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Method untuk memperbarui nama pengguna
    public function updateName(Request $request)
    {
        // Validasi input nama
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Perbarui nama pengguna
        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('profile')->with('success', 'Nama berhasil diperbarui.');
    }

    // Method for updating phone and KTP
    public function updateProfile(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'ktp_number' => 'required|string',
        ]);

        $user = auth()->user();

        $user->update([
            'phone' => $request->phone,
            'ktp_number' => $request->ktp_number,
            'akun' => 'terverifikasi',
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function updateDob(Request $request)
    {
        // Debugging - Log input data
        \Log::info($request->all());

        // Pastikan data ada dan valid
        if ($request->has('day') && $request->has('month') && $request->has('year')) {
            $dateOfBirth = Carbon::createFromDate($request->year, $request->month, $request->day);

            // Update atau simpan ke database
            $user = auth()->user();
            $user->tanggal_lahir = $dateOfBirth;
            $user->save();

            return redirect()->route('profile')->with('success', 'Tanggal lahir berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Data tidak lengkap');
    }


    // Fungsi untuk memperbarui jenis kelamin
    public function updateGender(Request $request)
    {
        $request->validate([
            'jenis_kelamin' => 'required|string',
        ]);

        $user = auth()->user();
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->save();

        return redirect()->route('profile')->with('success', 'Jenis kelamin berhasil diperbarui');
    }

    public function sendEmailConfirmation(Request $request)
    {
        $request->validate([
            'email_baru' => 'required|email|unique:users,email',
        ]);

        $user = Auth::user();
        $token = Str::random(64);

        // Simpan token ke session atau database (pilihan Anda)
        $user->update([
            'email_change_token' => $token,
            'email_change_new' => $request->email_baru,
        ]);

        // Kirim email konfirmasi ke email lama
        $data = [
            'link' => route('profile.confirmEmail', $token),
            'email_baru' => $request->email_baru,
            'email_lama' => $user->email,
        ];

        Mail::send('emails.confirm-email-change', $data, function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Konfirmasi Perubahan Email');
        });

        return back()->with('success', 'Email konfirmasi telah dikirim ke email lama Anda.');
    }

    public function confirmEmail($token)
    {
        $user = Auth::user();

        if ($user->email_change_token === $token) {
            // Update email
            $user->update([
                'email' => $user->email_change_new,
                'email_change_token' => null,
                'email_change_new' => null,
            ]);

            return redirect()->route('profile')->with('success', 'Email berhasil diperbarui.');
        }

        return redirect()->route('profile')->with('error', 'Token tidak valid.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail('Password lama tidak benar.');
                }
            }],
            'new_password' => ['required', 'min:8'],
            'new_password_confirmation' => ['required', 'same:new_password'],
        ]);

        // Jika validasi lolos, ganti password
        $user = auth()->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

    public function uploadPhoto(Request $request)
    {
        // Validasi foto yang diupload
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:10240', // Maksimal 10MB
        ]);

        // Ambil file foto yang diupload
        $file = $request->file('photo');

        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->profile_image) {
            $oldFilePath = storage_path('app/public/' . $user->profile_image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // Buat nama file baru dengan username + string acak
        $fileName = $user->username . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Simpan file di folder 'public/profiles' dan ambil path-nya
        $filePath = $file->storeAs('profile-pic', $fileName, 'public');

        // Update profil pengguna dengan path file yang baru
        $user->profile_image = $filePath;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
    }

}
