<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        return view('pages.admin.main'); // Nama view yang akan ditampilkan
    }

    public function dataAdminDashboard(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $users = User::whereIn('role', ['admin', 'superadmin'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->get();

        return view('pages.admin.data-admin', compact('users'));
    }

    // Menyimpan admin baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'nullable|max:100',
            'phone' => 'nullable|max:20',
            'role' => 'required|in:admin,superadmin',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => 'active',
        ]);

        return redirect()->route('data-admin.dashboard')->with('success', 'Admin berhasil ditambahkan.');
    }

    // Mengupdate data admin
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $id . '|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'name' => 'nullable|max:100',
            'phone' => 'nullable|max:20',
            'role' => 'required|in:admin,superadmin',
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'name' => $request->name,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('data-admin.dashboard')->with('success', 'Data admin berhasil diupdate.');
    }

    // Menghapus admin
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'superadmin') {
            return redirect()->route('data-admin.dashboard')->with('error', 'Superadmin tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('data-admin.dashboard')->with('success', 'Admin berhasil dihapus.');
    }

    // Ban atau unban admin
    public function changeStatus($id)
    {
        $user = User::findOrFail($id);

        $user->status = $user->status === 'active' ? 'banned' : 'active';
        $user->save();

        return redirect()->route('data-admin.dashboard')->with('success', 'Status admin berhasil diubah.');
    }
}
