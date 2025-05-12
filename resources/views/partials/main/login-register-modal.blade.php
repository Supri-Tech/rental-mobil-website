<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title text-center" id="loginModalLabel">Masuk</h5>
                <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="loginEmail" name="email" required>
                        <div id="emailError" class="text-danger mt-1"></div> <!-- Pesan error email -->
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordLogin">
                                <i class="fas fa-eye"></i> <!-- Ikon mata untuk menunjukkan password -->
                            </button>
                        </div>
                        <div id="passwordError" class="text-danger"></div> <!-- Pesan error password -->
                    </div>
                    <div class="d-flex justify-content-end mb-2">
                        <a href="#" class="text-decoration-none">Lupa kata sandi?</a>
                    </div>
                    <!-- Tombol Login -->
                    <button id="loginButton" type="submit" class="btn btn-primary w-100 py-2 rounded-pill">Masuk</button>
                </form>
                <hr>
                <!-- Tombol Login dengan Google -->
                <button type="button" class="btn btn-outline-danger w-100 rounded-pill py-2" onclick="window.location='{{ route('login.google') }}'">
                    <i class="fab fa-google me-2"></i> Masuk Dengan Google
                </button>
            </div>
            <div class="text-center mt-2">
                <p class="text-center w-100">Tidak Punya Akun? 
                    <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Daftar</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Register -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="registerModalLabel">Daftar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="registerPassword" name="password" required>
                                    <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <div id="registerPasswordStrength" class="progress">
                                        <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    <button type="button" id="toggleConfirmPassword" class="btn btn-outline-secondary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div id="passwordMatchMessage" class="text-danger"></div> <!-- Pesan jika password tidak cocok -->
                            </div>
                            <div class="mb-3">
                                <label for="ktp_number" class="form-label">Nomor KTP</label>
                                <input type="text" class="form-control" id="ktp_number" name="ktp_number" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">Daftar</button>
                    <hr>
                    <button type="button" class="btn btn-outline-danger w-100 rounded-pill py-2" onclick="window.location='{{ route('login.google') }}'">
                        <i class="fab fa-google me-2"></i> Daftar Dengan Google
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginPasswordInput = document.getElementById('loginPassword');
        const passwordInput = document.getElementById('registerPassword');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const strengthBar = document.getElementById('passwordStrengthBar');
        const strengthIndicator = document.getElementById('registerPasswordStrength');
        const passwordMatchMessage = document.getElementById('passwordMatchMessage');

        // Fungsi untuk menghitung kekuatan password
        function updatePasswordStrength(password) {
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[\W]/.test(password)) strength++;

            const strengths = ['Weak', 'Fair', 'Good', 'Strong', 'Very Strong'];
            const colors = ['red', 'orange', 'yellow', 'green', 'blue'];

            const strengthLevel = strength - 1;
            strengthBar.style.width = (strength * 20) + '%';
            strengthBar.style.backgroundColor = colors[strengthLevel] || 'red';
            strengthIndicator.style.display = 'block'; // Menampilkan bar
        }

        // Memeriksa kecocokan password
        function checkPasswordMatch() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                passwordMatchMessage.textContent = 'Password tidak sama';
            } else {
                passwordMatchMessage.textContent = '';
            }
        }

        // Event listener untuk input password
        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                updatePasswordStrength(this.value);
            });
        }

        // Event listener untuk konfirmasi password
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', function () {
                checkPasswordMatch();
            });
        }

        // Menambahkan fungsionalitas untuk melihat dan menyembunyikan password
        const toggleLoginPassword = document.getElementById('togglePasswordLogin');
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

        if (loginPasswordInput && togglePasswordLogin) {
            togglePasswordLogin.addEventListener('click', function () {
                const type = loginPasswordInput.type === "password" ? "text" : "password";
                loginPasswordInput.type = type;
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }

        if (togglePassword) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.type === "password" ? "text" : "password";
                passwordInput.type = type;
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }

        if (toggleConfirmPassword) {
            toggleConfirmPassword.addEventListener('click', function () {
                const type = confirmPasswordInput.type === "password" ? "text" : "password";
                confirmPasswordInput.type = type;
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const loginForm = document.getElementById('loginForm');
        const spinner = document.getElementById('spinner'); // Spinner dengan ID 'spinner'
        const loginButton = document.getElementById('loginButton');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');

        loginForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Mencegah reload halaman
            emailError.textContent = ''; // Reset pesan error
            passwordError.textContent = ''; // Reset pesan error

            // Tampilkan spinner saat proses login
            spinner.classList.remove('d-none');
            loginButton.disabled = true; // Nonaktifkan tombol login

            // Kirim data form menggunakan AJAX
            fetch('{{ route('login') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: document.getElementById('loginEmail').value,
                    password: document.getElementById('loginPassword').value,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    // Sembunyikan spinner setelah mendapatkan respons
                    spinner.classList.add('d-none');
                    loginButton.disabled = false; // Aktifkan tombol login

                    if (data.success) {
                        // Login berhasil, redirect ke halaman tujuan
                        window.location.href = data.redirect;
                    } else {
                        // Login gagal, tampilkan pesan error
                        if (data.errors.email) {
                            emailError.textContent = data.errors.email;
                        }
                        if (data.errors.password) {
                            passwordError.textContent = data.errors.password;
                        }
                    }
                })
                .catch((error) => {
                    // Sembunyikan spinner jika ada kesalahan
                    spinner.classList.add('d-none');
                    loginButton.disabled = false; // Aktifkan tombol login
                    emailError.textContent = 'Terjadi kesalahan, silakan coba lagi.';
                });
        });
    });


</script>