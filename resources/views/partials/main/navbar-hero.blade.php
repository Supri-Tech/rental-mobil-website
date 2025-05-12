<!-- Navbar & Hero Start -->
<div class="container-fluid nav-bar sticky-top px-0 px-lg-4 py-2 py-lg-0">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="{{ route('main') }}" class="navbar-brand p-0">
                <h1 class="display-6 text-primary"><i class="fas fa-car-alt me-3"></i>FregaTrans</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="{{ route('main') }}" class="nav-item nav-link {{ request()->routeIs('main') ? 'active' : '' }}">Beranda</a>
                    <a href="#" class="nav-item nav-link">Rental Mobil</a>
                    <a href="#" class="nav-item nav-link">Tentang Kami</a>
                    <a href="#" class="nav-item nav-link">Layanan</a>
                    <a href="#" class="nav-item nav-link">Kontak</a>
                </div>
                @auth
                <!-- Jika pengguna sudah login -->
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('storage/profile-pic/default-profile.jpg') }}" alt="Profile" class="rounded-circle me-2" style="width: 50px; height: 50px;">
                        <div>
                            <span class="username">{{ Auth::user()->username }}</span> <!-- Nama pengguna, lebih besar -->
                            @if(in_array(Auth::user()->role, ['admin', 'superadmin'])) <!-- Cek jika role adalah admin atau superadmin -->
                                <div class="text-muted">{{ ucfirst(Auth::user()->role) }}</div> <!-- Role ditampilkan jika admin atau superadmin -->
                            @endif
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <div class="profile-card">
                            <h5>{{ Auth::user()->name }}</h5>
                            <p>{{ Auth::user()->email }}</p>
                            <ul class="list-group list-group-flush mt-3">
                                @if(in_array(Auth::user()->role, ['admin', 'superadmin'])) <!-- Cek jika role adalah admin atau superadmin -->
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center full-width" onclick="window.location='/dashboard';">
                                            <i class="fas"></i> <span class="green-text">Dashboard Admin</span>
                                        </div>
                                    </li>
                                @endif
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center full-width" onclick="window.location='/user/profile';">
                                        <i class="fas fa-user"></i> Profile
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center full-width">
                                        <i class="fas fa-car"></i> Pesanan anda
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center full-width">
                                        <i class="fas fa-cog"></i> Pengaturan
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center full-width" 
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Log out
                                    </div>
                                </li>

                                <!-- Form Logout -->
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>

                @else
                <!-- Jika pengguna belum login -->
                <a href="#" class="btn btn-outline-primary rounded-pill py-2 px-4 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a>
                @endauth
            </div>
        </nav>
    </div>
</div>
<!-- Navbar & Hero End -->

@include('partials.main.login-register-modal')