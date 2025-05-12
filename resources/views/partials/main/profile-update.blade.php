@if(auth()->check())
<div class="modal fade" id="profileUpdateModal" tabindex="-1" aria-labelledby="profileUpdateModalLabel" aria-hidden="true" style="display: {{ $showUpdateModal ? 'block' : 'none' }};">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileUpdateModalLabel">Perbarui Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-4 text-left">
                    Untuk menikmati fitur sewa mobil dari FregaTrans, mohon lengkapi data Anda. Kami memerlukan nomor telepon dan nomor KTP Anda untuk verifikasi.
                </p>
                <form id="profileUpdateForm" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="phone">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="ktp_number">Nomor KTP</label>
                        <input type="text" class="form-control" id="ktp_number" name="ktp_number" value="{{ old('ktp_number') }}" required>
                        @error('ktp_number')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Tombol Simpan -->
                    <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Update Nama -->
<div class="modal fade" id="updateNameModal" tabindex="-1" aria-labelledby="updateNameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateNameModalLabel">Perbarui Nama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">
                    Perbarui nama lengkap Anda untuk memastikan profil Anda up-to-date.
                </p>
                <form id="updateNameForm" method="POST" action="{{ route('profile.updateName') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Tanggal Lahir -->
<div class="modal fade" id="updateDobModal" tabindex="-1" aria-labelledby="updateDobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDobModalLabel">Perbarui Tanggal Lahir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateDobForm" method="POST" action="{{ route('profile.updateDob') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="tanggal_lahir">Perbarui tanggal lahir dan pilih tanggal, bulan, dan tahun kelahiran Anda</label>
                        <div class="d-flex mt-3">
                            <!-- Dropdown Tanggal -->
                            <select class="form-control" id="day" name="day" required>
                                <option value="" disabled selected>Pilih Tanggal</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ $i }}</option>
                                @endfor
                            </select>

                            <!-- Dropdown Bulan -->
                            <select class="form-control mx-2" id="month" name="month" required>
                                <option value="" disabled selected>Pilih Bulan</option>
                                @foreach ([
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', 
                                    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', 
                                    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ] as $key => $month)
                                    <option value="{{ $key }}">{{ $month }}</option>
                                @endforeach
                            </select>

                            <!-- Dropdown Tahun -->
                            <select class="form-control" id="year" name="year" required>
                                <option value="" disabled selected>Pilih Tahun</option>
                                @for ($i = date('Y'); $i >= 1900; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal Update Jenis Kelamin -->
<div class="modal fade" id="updateGenderModal" tabindex="-1" aria-labelledby="updateGenderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateGenderModalLabel">Perbarui Jenis Kelamin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateGenderForm" method="POST" action="{{ route('profile.updateGender') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="jenis_kelamin">Perbarui dan pilih jenis kelamin Anda (Laki - Laki atau Perempuan)</label><br>
                        <div class="d-flex justify-content-center mt-3">
                            <div class="mx-3 d-flex align-items-center">
                                <input type="radio" id="pria" name="jenis_kelamin" value="Laki - Laki" {{ auth()->user()->jenis_kelamin == 'Laki - Laki' ? 'checked' : '' }} class="form-check-input" style="transform: scale(1.5);">
                                <label for="pria" style="font-size: 18px; display: flex; align-items: center; margin-left: 8px;">
                                    <img src="{{ asset('assets/img/male.png') }}" alt="Laki - Laki" width="80" height="90" class="me-2">
                                    Laki - Laki
                                </label>
                            </div>
                            <div class="mx-3 d-flex align-items-center">
                                <input type="radio" id="wanita" name="jenis_kelamin" value="Perempuan" {{ auth()->user()->jenis_kelamin == 'Perempuan' ? 'checked' : '' }} class="form-check-input" style="transform: scale(1.5);">
                                <label for="wanita" style="font-size: 18px; display: flex; align-items: center; margin-left: 8px;">
                                    <img src="{{ asset('assets/img/femele.png') }}" alt="Perempuan" width="80" height="90" class="me-2">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Email -->
<div class="modal fade" id="updateEmailModal" tabindex="-1" aria-labelledby="updateEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateEmailModalLabel">Ubah Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Perhatian:</strong> Kami akan mengirimkan email konfirmasi ke email lama Anda. Klik link dalam email untuk mengonfirmasi perubahan.
                </div>
                <form id="updateEmailForm" method="POST" action="{{ route('profile.updateEmailRequest') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email_baru">Email Baru</label>
                        <input type="email" class="form-control mt-2" id="email_baru" name="email_baru" placeholder="Masukkan email baru ( example@gmail.com )" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Perhatian:</strong> Harap pastikan password lama Anda benar sebelum mengubah ke password baru.
                </div>
                <form id="updatePasswordForm" method="POST" action="{{ route('profile.updatePassword') }}">
                    @csrf

                    <!-- Password Lama -->
                    <div class="form-group mb-3">
                        <label for="current_password">Password Lama</label>
                        <input 
                            type="password" 
                            class="form-control mt-2 @error('current_password') is-invalid @enderror" 
                            id="current_password" 
                            name="current_password" 
                            placeholder="Masukkan password lama" 
                            required>
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="form-group mb-3">
                        <label for="new_password">Password Baru</label>
                        <input 
                            type="password" 
                            class="form-control mt-2 @error('new_password') is-invalid @enderror" 
                            id="new_password" 
                            name="new_password" 
                            placeholder="Masukkan password baru" 
                            required>
                        @error('new_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="form-group mb-3">
                        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        <input 
                            type="password" 
                            class="form-control mt-2 @error('new_password_confirmation') is-invalid @enderror" 
                            id="new_password_confirmation" 
                            name="new_password_confirmation" 
                            placeholder="Konfirmasi password baru" 
                            required>
                        @error('new_password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-primary w-100">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endif
