            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav" id="sidebarMenu">
                            <!-- Dashboard -->
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            <!-- Manajemen Mobil Rental -->
                            <div class="sb-sidenav-menu-heading">Manajemen Rental</div>
                            <a class="nav-link" href="{{ route('kategori-mobil.dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-car"></i></div>
                                Kategori Mobil
                            </a>
                            <a class="nav-link" href="{{ route('data-mobil.dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-car"></i></div>
                                Data Mobil
                            </a>

                            <!-- Manajemen Pelanggan -->
                            <div class="sb-sidenav-menu-heading">Manajemen Pengguna</div>
                            <a class="nav-link" href="{{ route('users.dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Data Pelanggan
                            </a>
                            <a class="nav-link" href="{{ route('data-admin.dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Data Admin
                            </a>

                            <!-- Transaksi -->
                            <div class="sb-sidenav-menu-heading">Transaksi & Pemesanan</div>
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#transaksiDropdown" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Transaksi Rental
                            </a>
                            <div class="collapse" id="transaksiDropdown">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="pesanan-baru.html">Pesanan Baru</a>
                                    <a class="nav-link" href="transaksi-berlangsung.html">Transaksi Berlangsung</a>
                                    <a class="nav-link" href="riwayat-transaksi.html">Riwayat Transaksi</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="jadwal-pemesanan.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar"></i></div>
                                Jadwal Pemesanan
                            </a>
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#laporanDropdown" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                Laporan Rental
                            </a>
                            <div class="collapse" id="laporanDropdown">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="laporan-pendapatan.html">Laporan Pendapatan</a>
                                    <a class="nav-link" href="laporan-penggunaan-mobil.html">Laporan Penggunaan Mobil</a>
                                    <a class="nav-link" href="laporan-transaksi.html">Laporan Transaksi</a>
                                </nav>
                            </div>

                            <!-- Pengaturan -->
                            <div class="sb-sidenav-menu-heading">Pengaturan</div>
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#pengaturanDropdown" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                                Pengaturan Sistem
                            </a>
                            <div class="collapse" id="pengaturanDropdown">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="pengaturan-harga.html">Pengaturan Harga</a>
                                    <a class="nav-link" href="pengaturan-sistem.html">Pengaturan Sistem</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>