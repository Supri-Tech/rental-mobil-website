@extends('layouts.admin')
@section('title', 'FregaTrans Dashboard - Data Pemesanan')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Pemesanan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Data Pemesanan Fregatrans</li>
            </ol>
            <div class="row">
                <div class="card mb-4">
                    <div class="card-body">
                        <table id="datatablesSimple"
                            class="table table-bordered table-hover table-striped align-middle text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Gambar</th>
                                    <th>Model</th>
                                    <th>User</th>
                                    <th>Jarak Tempuh</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $car)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $car->car->image_primary) }}"
                                                alt="{{ $car->car->model }}" class="img-thumbnail"
                                                style="width: 80px; height: auto;">
                                        </td>
                                        <td>{{ $car->car->model ?? 'Tidak Ada Kategori' }}</td>
                                        <td>{{ $car->user->name }}</td>
                                        <td>{{ rtrim(rtrim($car->distance, '0'), '.') }} <strong>Km</strong></td>
                                        <td>
                                            @if ($car->status === 'pending')
                                                <span
                                                    class="badge bg-warning text-dark text-capitalize">{{ $car->status }}</span>
                                            @elseif ($car->status === 'approved')
                                                <span class="badge bg-success text-capitalize">{{ $car->status }}</span>
                                            @elseif ($car->status === 'rejected')
                                                <span class="badge bg-danger text-capitalize">{{ $car->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
