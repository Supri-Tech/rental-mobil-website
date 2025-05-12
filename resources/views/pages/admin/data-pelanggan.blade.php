@extends('layouts.admin')

@section('title', 'FregaTrans Dashboard')

@section('content')

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Pelanggan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Data Pelanggan Fregatrans</li>
        </ol>
        
        <!-- Filter dan Search -->
        <div class="card mb-4">
            <div class="card-header">
                <form action="{{ route('users.dashboard') }}" method="GET" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Dibanned</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Data Pelanggan
                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah Pelanggan</button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Status</th>
                            <th>Akun</th>
                            <th>Role</th>
                            <th>Nomor KTP</th>
                            <th>Google ID</th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>{{ ucfirst($user->akun) }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>{{ $user->ktp_number ?? 'N/A' }}</td>
                                <td>{{ $user->google_id ?? 'N/A' }}</td>
                                <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editUser({{ $user }})" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</button>
                                    <form action="{{ route('users.changeStatus', $user->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-{{ $user->status == 'active' ? 'danger' : 'success' }} btn-sm">
                                            {{ $user->status == 'active' ? 'Ban' : 'Unban' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pelanggan -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('users.update', $user->id) }}" method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit Pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="editUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="editEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="editPassword" placeholder="Kosongkan jika tidak ingin diubah">
                        </div>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" id="editName">
                        </div>
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control" id="editPhone">
                        </div>
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select name="role" id="editRole" class="form-select">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="superadmin">Superadmin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editKtpNumber" class="form-label">Nomor KTP</label>
                            <input type="text" name="ktp_number" class="form-control" id="editKtpNumber">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah Pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control" id="phone">
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function editUser(user) {
            document.getElementById('editUsername').value = user.username;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editName').value = user.name;
            document.getElementById('editPhone').value = user.phone;
            document.getElementById('editRole').value = user.role;
            document.getElementById('editKtpNumber').value = user.ktp_number ?? '';
            document.getElementById('editAkun').value = user.akun;

            // Reset password input
            document.getElementById('editPassword').value = '';

            const editForm = document.getElementById('editUserForm');
        }
    </script>

</main>


@endsection