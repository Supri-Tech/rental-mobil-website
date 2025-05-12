@extends('layouts.main')

@section('title', 'FregaTrans Rental Mobil')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="profile-sidebar">
                    <!-- Profile Header -->
                    <div class="d-flex align-items-center profile-header-container">
                        <div class="profile-header w-100 d-flex align-items-center">
                            <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('storage/profile-pic/default-profile.jpg') }}" 
                                alt="Profile Picture" 
                                class="img-fluid profile-pic" />
                            <h5 class="ms-2 mb-0">{{ Auth::user()->username }}</h5>
                        </div>
                    </div>

                    <!-- Verifikasi Akun -->
                    <div class="mt-3 sidebar-dropdown">
                        @if (auth()->user()->akun == 'terverifikasi')
                            <!-- Akun Terverifikasi -->
                            <div class="data-completion-container">
                                <p class="text-success">
                                    <strong>Akun Anda Telah Terverifikasi</strong><br />
                                    Anda dapat menikmati semua fitur terbaik di FregaTrans!
                                </p>
                            </div>
                        @else
                            <!-- Akun Belum Terverifikasi -->
                            <div class="data-completion-container">
                                <p>
                                    <strong>VERIFIKASI AKUN ANDA</strong><br />
                                    Untuk memesan rental mobil dan menikmati semua fitur terbaik di FregaTrans, kami memerlukan data KTP dan nomor telepon Anda untuk verifikasi!
                                </p>
                                <button class="btn btn-success btn-sm w-100 mb-2" data-bs-toggle="modal" data-bs-target="#profileUpdateModal">
                                    Verifikasi Sekarang
                                </button>
                            </div>
                        @endif
                    </div>
                    <!-- Pembelian Section -->
                    <div class="mt-3 sidebar-dropdown">
                        <h6 class="d-flex justify-content-between align-items-center">
                            Pemesanan
                            <button class="btn btn-link btn-sm" data-bs-toggle="collapse" data-bs-target="#pemesananDropdown">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </h6>
                        <div id="pemesananDropdown" class="collapse">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a href="#" class="nav-link">Pesanan Anda</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Menunggu Pembayaran</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Riwayat Pemesanan</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Profil Saya Section -->
                    <div class="mt-3 sidebar-dropdown">
                        <h6 class="d-flex justify-content-between align-items-center">
                            Profil Saya
                            <button class="btn btn-link btn-sm" data-bs-toggle="collapse" data-bs-target="#profilDropdown">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </h6>
                        <div id="profilDropdown" class="collapse">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a href="#" class="nav-link">Alamat Anda</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Pengaturan</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Pusat Bantuan Section -->
                    <div class="mt-3 sidebar-dropdown">
                        <h6 class="d-flex justify-content-between align-items-center">
                            Pusat Bantuan
                            <button class="btn btn-link btn-sm" data-bs-toggle="collapse" data-bs-target="#bantuanDropdown">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </h6>
                        <div id="bantuanDropdown" class="collapse">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a href="#" class="nav-link">FAQ / Panduan</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Layanan Pelanggan</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Pengajuan Komplain</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Content -->
            <div class="col-md-9">
                <div class="profile-content">
                    <h5>{{ Auth::user()->name }}</h5>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a href="#" class="nav-link active">Biodata Diri</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Alamat Anda</a></li>
                    </ul>

                    <!-- Biodata Section -->
                    <div class="mt-3">
                        <div class="row">
                            <!-- Profile Picture -->
                            <div class="col-md-4 text-center">
                                <div class="profile-pic-container">
                                    <!-- Menampilkan foto profil yang diupload, jika tidak ada, tampilkan foto default -->
                                    <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('storage/profile-pic/default-profile.jpg') }}" 
                                        alt="Profile Picture" 
                                        class="img-fluid mb-3" 
                                        style="border-radius: 50%; width: 250px; height: 250px;" />

                                    <!-- Form untuk mengupload foto profil -->
                                    <form action="{{ route('profile.upload_photo') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="photo" class="form-control mb-2">
                                        <button type="submit" class="btn btn-outline-primary btn-sm w-100">Pilih Foto</button>
                                    </form>

                                    <p class="text-muted mt-2">
                                        Besar file maksimum 10 MB. Ekstensi file yang diperbolehkan: JPG, JPEG, PNG.
                                    </p>
                                </div>

                                <button id="updatePasswordButton" class="btn btn-outline-primary btn-sm w-100 mt-3" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">Ubah Kata Sandi</button>
                            </div>


                            <!-- Biodata Form -->
                            <div class="col-md-8 p-3">
                                <h6>Ubah Biodata Diri</h6>
                                <!-- Nama -->
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-4 col-form-label">Nama</label>
                                    <div class="col-sm-8">
                                        <p class="mb-0">{{ Auth::user()->name }} 
                                            <a href="#" class="text-primary text-decoration-none ms-2" data-bs-toggle="modal" data-bs-target="#updateNameModal">Ubah</a>
                                        </p>
                                    </div>
                                </div>

                                <!-- Nama -->
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-4 col-form-label">No KTP</label>
                                    <div class="col-sm-8">
                                        @if (Auth::user()->ktp_number) <!-- Mengecek apakah nomor KTP ada -->
                                            <!-- Jika KTP terisi, tampilkan status "Terverifikasi" -->
                                            <p class="mb-0">{{ Auth::user()->ktp_number}}<span class="badge bg-success ms-2">Terverifikasi</span></p> 
                                        @else
                                            <!-- Jika KTP kosong, tampilkan tombol "Tambah" -->
                                            <p class="mb-0">
                                                <a href="#" class="" data-bs-toggle="modal" data-bs-target="#profileUpdateModal">Tambah</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-8">
                                        @if(Auth::user()->tanggal_lahir)  <!-- Cek jika tanggal lahir sudah ada -->
                                            <p class="mb-0">{{ \Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->format('d F Y') }} <a href="#" class="ms-2" data-bs-toggle="modal" data-bs-target="#updateDobModal">Ubah Tanggal Lahir</a></p>
                                        @else
                                            <p class="mb-0"><a href="#" class="" data-bs-toggle="modal" data-bs-target="#updateDobModal">Tambah Tanggal Lahir</a></p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                        @if(Auth::user()->jenis_kelamin)
                                            <p class="mb-0">{{ Auth::user()->jenis_kelamin }} <a href="#" class="ms-2" data-bs-toggle="modal" data-bs-target="#updateGenderModal">Ubah Jenis Kelamin</a></p>
                                        @else
                                            <p class="mb-0"><a href="#" class="" data-bs-toggle="modal" data-bs-target="#updateGenderModal">Tambah Jenis Kelamin</a></p>
                                        @endif
                                    </div>
                                </div>

                                <h6>Ubah Kontak</h6>
                                <!-- Email -->
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <p class="mb-0">{{ Auth::user()->email }}<a href="#" class="ms-2" data-bs-toggle="modal" data-bs-target="#updateEmailModal">Ubah</a></p>
                                    </div>
                                </div>

                                <!-- Nomor HP -->
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-4 col-form-label">Nomor HP</label>
                                    <div class="col-sm-8">
                                        <p class="mb-0">
                                            {{ Auth::user()->phone }}
                                            <a href="#" class="ms-2">Ubah</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        const passwordMatchMessage = document.getElementById('passwordMatchMessage');
        const updatePasswordForm = document.getElementById('updatePasswordForm');

        function checkPasswordMatch() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                passwordMatchMessage.textContent = 'Password baru dan konfirmasi password tidak sama!';
                return false;
            } else {
                passwordMatchMessage.textContent = '';
                return true;
            }
        }

        if (passwordInput && confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        }

        updatePasswordForm.addEventListener('submit', function (event) {
            if (!checkPasswordMatch()) {
                event.preventDefault();
                alert('Pastikan password baru dan konfirmasi password sama!');
            }
        });
    });
    </script>
@endsection