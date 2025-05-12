<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    
    public function usersDashboard(Request $request)
    {
        // Mulai query untuk mengambil data pengguna
        $query = User::query();

        // Pencarian ber    dasarkan username atau nama
        if ($request->filled('search')) {
            $query->where('username', 'LIKE', "%{$request->search}%")
                ->orWhere('name', 'LIKE', "%{$request->search}%");
        }

        // Filter berdasarkan status pengguna
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan role pengguna (user, admin, superadmin)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Ambil data pengguna dengan pagination
        $users = $query->paginate(10); // Anda bisa menyesuaikan jumlah per halaman sesuai kebutuhan

        // Ambil daftar status dan role untuk filter di form
        $statuses = ['active', 'inactive', 'banned'];
        $roles = ['user', 'admin', 'superadmin'];

        // Kirim data pengguna dan filter ke view
        return view('pages.admin.data-pelanggan', compact('users', 'statuses', 'roles'));
    }


    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'nullable|max:100',
            'phone' => 'nullable|max:20',
            'ktp_number' => 'nullable|max:20',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'phone' => $request->phone,
            'ktp_number' => $request->ktp_number,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role' => 'user',
            'status' => 'active',
        ]);

        return redirect()->route('users.dashboard')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->only(['username', 'email', 'name', 'phone', 'role', 'ktp_number', 'akun']);

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('users.dashboard')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.dashboard')->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function changeStatus($id)
    {
        $user = User::findOrFail($id);

        $user->status = $user->status === 'active' ? 'banned' : 'active';
        $user->save();

        return redirect()->route('users.dashboard')->with('success', 'Status pelanggan berhasil diperbarui.');
    }
}
