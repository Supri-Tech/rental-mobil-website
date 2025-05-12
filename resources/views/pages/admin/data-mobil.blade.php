@extends('layouts.admin')

@section('title', 'FregaTrans Dashboard')

@section('content')
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Mobil</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Data Mobil Fregatrans</li>
                        </ol>
                        <!-- Filter dan Search -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <form action="{{ route('data-mobil.dashboard') }}" method="GET" class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau merek..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <select name="category_id" class="form-select">
                                            <option value="">Semua Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i> Data Mobil Rental
                                <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addCarModal">Tambah Mobil</button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-bordered">
                                    <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>Kategori</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Plat Nomor</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cars as $car)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $car->category->name ?? 'Tidak Ada Kategori' }}</td>
                                            <td>{{ $car->brand }}</td>
                                            <td>{{ $car->model }}</td>
                                            <td>{{ $car->license_plate }}</td>
                                            <td>
                                                @if ($car->status == 'Tersedia')
                                                    <button class="btn btn-success btn-sm">{{ $car->status }}</button>
                                                @elseif ($car->status == 'Diperbaiki')
                                                    <button class="btn btn-warning btn-sm">{{ $car->status }}</button>
                                                @elseif ($car->status == 'Tidak Aktif')
                                                    <button class="btn btn-danger btn-sm">{{ $car->status }}</button>
                                                @else
                                                    <button class="btn btn-secondary btn-sm">Status Tidak Diketahui</button>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" onclick="editCar({{ $car }})" data-bs-toggle="modal" data-bs-target="#EditModal">Edit</button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteCar({{ $car->id }})" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                                            
                                                <!-- Modal Delete -->
                                                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('cars.destroy', $car->id) }}" id="deleteForm" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel">Hapus Mobil</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin menghapus mobil ini?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <form id="addEditForm" 
                                                                action="{{ isset($car) ? route('cars.update', $car->id) : route('cars.store') }}" 
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @if (isset($car))
                                                                    @method('PUT')
                                                                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                                                                @endif
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="EditModalLabel">{{ isset($car) ? 'Edit Mobil' : 'Tambah Mobil' }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Baris 1: Kategori dan Brand -->
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="category_id" class="form-label">Kategori</label>
                                                                            <select class="form-select" name="category_id" id="category_id">
                                                                                <option value="">Pilih Kategori</option>
                                                                                @foreach ($categories as $category)
                                                                                    <option value="{{ $category->id }}" 
                                                                                        {{ isset($car) && $car->category_id == $category->id ? 'selected' : '' }}>
                                                                                        {{ $category->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="brand" class="form-label">Brand</label>
                                                                            <input type="text" class="form-control" id="brand" name="brand" 
                                                                                value="{{ isset($car) ? $car->brand : '' }}" required>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Baris 2: Model dan Plat Nomor -->
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="model" class="form-label">Model</label>
                                                                            <input type="text" class="form-control" id="model" name="model" 
                                                                                value="{{ isset($car) ? $car->model : '' }}" required>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="license_plate" class="form-label">Plat Nomor</label>
                                                                            <input type="text" class="form-control" id="license_plate" name="license_plate" 
                                                                                value="{{ isset($car) ? $car->license_plate : '' }}" required>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Baris 3: Tahun dan Transmisi -->
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="year" class="form-label">Tahun</label>
                                                                            <input type="number" class="form-control" id="year" name="year" 
                                                                                value="{{ isset($car) ? $car->year : '' }}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="transmission" class="form-label">Transmisi</label>
                                                                            <select class="form-select" name="transmission" id="transmission">
                                                                                <option value="Manual" {{ isset($car) && $car->transmission == 'Manual' ? 'selected' : '' }}>Manual</option>
                                                                                <option value="Automatic" {{ isset($car) && $car->transmission == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                                                                <option value="Semi-Automatic" {{ isset($car) && $car->transmission == 'Semi-Automatic' ? 'selected' : '' }}>Semi-Automatic</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Baris 4: Bahan Bakar dan Kapasitas Penumpang -->
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="fuel_type" class="form-label">Jenis Bahan Bakar</label>
                                                                            <select class="form-select" name="fuel_type" id="fuel_type">
                                                                                <option value="Bensin" {{ isset($car) && $car->fuel_type == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                                                                                <option value="Diesel" {{ isset($car) && $car->fuel_type == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                                                                <option value="Hybrid" {{ isset($car) && $car->fuel_type == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                                                                <option value="Elektrik" {{ isset($car) && $car->fuel_type == 'Elektrik' ? 'selected' : '' }}>Elektrik</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="passenger_capacity" class="form-label">Kapasitas Penumpang</label>
                                                                            <input type="number" class="form-control" id="passenger_capacity" name="passenger_capacity" 
                                                                                value="{{ isset($car) ? $car->passenger_capacity : '' }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Baris 5: Harga Sewa dan Status -->
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="base_price_per_day" class="form-label">Harga Sewa Per Hari</label>
                                                                            <input type="text" class="form-control" id="base_price_per_day" name="base_price_per_day" 
                                                                                value="{{ isset($car) ? $car->base_price_per_day : '' }}">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label for="status" class="form-label">Status</label>
                                                                            <select class="form-select" name="status" id="status">
                                                                                <option value="Tersedia" {{ isset($car) && $car->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                                                <option value="Diperbaiki" {{ isset($car) && $car->status == 'Diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                                                                                <option value="Tidak Aktif" {{ isset($car) && $car->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Baris 6: Foto Utama -->
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <label for="image_primary" class="form-label">Foto Utama</label>
                                                                            <!-- Tampilkan gambar saat ini jika ada -->
                                                                            @if(isset($car->image_primary) && $car->image_primary)
                                                                                <div class="mb-2">
                                                                                    <img id="currentImage" src="{{ asset('storage/' . $car->image_primary) }}" alt="Current Image" style="max-width: 100%; max-height: 300px;">
                                                                                </div>
                                                                            @else
                                                                                <p>Tidak ada gambar yang diunggah sebelumnya.</p>
                                                                            @endif

                                                                            <!-- Input untuk memilih file gambar -->
                                                                            <input type="file" class="form-control" id="image_primary" name="image_primary" onchange="previewImage(event)">
                                                                            
                                                                            <!-- Preview gambar yang diupload -->
                                                                            <div class="mt-2">
                                                                                <img id="imagePreview" src="#" alt="Preview Gambar" style="max-width: 100%; max-height: 300px; display: none;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary">{{ isset($car) ? 'Update' : 'Simpan' }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </main>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Add/Edit -->
                        <div class="modal fade" id="addCarModal" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form id="addEditForm" action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addCarModalLabel">Tambah Mobil</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="car_id" name="car_id">
                                            
                                            <!-- Baris 1: Kategori dan Brand -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="category_id" class="form-label">Kategori</label>
                                                    <select class="form-select" name="category_id" id="category_id">
                                                        <option value="">Pilih Kategori</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="brand" class="form-label">Brand</label>
                                                    <input type="text" class="form-control" id="brand" name="brand" required>
                                                </div>
                                            </div>
                                            
                                            <!-- Baris 2: Model dan Plat Nomor -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="model" class="form-label">Model</label>
                                                    <input type="text" class="form-control" id="model" name="model" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="license_plate" class="form-label">Plat Nomor</label>
                                                    <input type="text" class="form-control" id="license_plate" name="license_plate" required>
                                                </div>
                                            </div>
                                            
                                            <!-- Baris 3: Tahun dan Transmisi -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="year" class="form-label">Tahun</label>
                                                    <input type="number" class="form-control" id="year" name="year">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="transmission" class="form-label">Transmisi</label>
                                                    <select class="form-select" name="transmission" id="transmission">
                                                        <option value="">Pilih Transmisi</option>
                                                        <option value="Manual">Manual</option>
                                                        <option value="Automatic">Automatic</option>
                                                        <option value="Semi-Automatic">Semi-Automatic</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Baris 4: Bahan Bakar dan Kapasitas Penumpang -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="fuel_type" class="form-label">Jenis Bahan Bakar</label>
                                                    <select class="form-select" name="fuel_type" id="fuel_type">
                                                        <option value="">Pilih Bahan Bakar</option>
                                                        <option value="Bensin">Bensin</option>
                                                        <option value="Diesel">Diesel</option>
                                                        <option value="Hybrid">Hybrid</option>
                                                        <option value="Elektrik">Elektrik</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="passenger_capacity" class="form-label">Kapasitas Penumpang</label>
                                                    <input type="number" class="form-control" id="passenger_capacity" name="passenger_capacity">
                                                </div>
                                            </div>
                                            
                                            <!-- Baris 5: Harga Sewa dan Status -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="base_price_per_day" class="form-label">Harga Sewa Per Hari</label>
                                                    <input type="text" class="form-control" id="base_price_per_day" name="base_price_per_day">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" name="status" id="status">
                                                        <option value="Tersedia">Tersedia</option>
                                                        <option value="Diperbaiki">Diperbaiki</option>
                                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Input untuk Foto Utama -->
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="image_primary" class="form-label">Foto Utama</label>
                                                    <input type="file" class="form-control" id="image_primary" name="image_primary" onchange="previewImage(event)">
                                                    <div class="mt-2" id="primaryImagePreview">
                                                        <!-- Tempat untuk menampilkan preview gambar utama -->
                                                    </div>
                                                </div>
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
                            // Fungsi untuk preview gambar utama
                            function previewImage(event) {
                                // Ambil file dari input
                                const file = event.target.files[0];
                                if (!file) {
                                    console.error("Tidak ada file yang dipilih untuk gambar utama.");
                                    return;
                                }

                                // Dapatkan elemen kontainer untuk preview gambar utama
                                const container = document.getElementById('primaryImagePreview');
                                if (!container) {
                                    console.error("Kontainer untuk preview gambar utama tidak ditemukan.");
                                    return;
                                }

                                // Bersihkan kontainer sebelumnya
                                container.innerHTML = '';

                                // Membaca file dan menampilkan preview
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.style.maxWidth = '100%';
                                    img.style.maxHeight = '300px';
                                    container.appendChild(img);
                                };
                                reader.readAsDataURL(file);
                            }

                            // Fungsi untuk preview gambar tambahan
                            function previewAdditionalImages(event) {
                                // Ambil semua file dari input
                                const files = event.target.files;
                                if (!files.length) {
                                    console.error("Tidak ada file yang dipilih untuk gambar tambahan.");
                                    return;
                                }

                                // Dapatkan elemen kontainer untuk preview gambar tambahan
                                const container = document.getElementById('additionalImagePreviewContainer');
                                if (!container) {
                                    console.error("Kontainer untuk preview gambar tambahan tidak ditemukan.");
                                    return;
                                }

                                // Bersihkan kontainer sebelumnya
                                container.innerHTML = '';

                                // Membaca file satu per satu dan menampilkan preview
                                Array.from(files).forEach(file => {
                                    const reader = new FileReader();
                                    reader.onload = function (e) {
                                        const img = document.createElement('img');
                                        img.src = e.target.result;
                                        img.src = e.target.result;
                                        img.style.maxWidth = '100%';
                                        img.style.maxHeight = '300px';
                                        container.appendChild(img);
                                    };
                                    reader.readAsDataURL(file);
                                });
                            }
                        </script>
                </main>

@endsection