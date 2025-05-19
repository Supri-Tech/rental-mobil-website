@extends('layouts.admin')

@section('title', 'FregaTrans Dashboard - Data Pesanan Baru')

@section('content')
    <div class="container mt-4">
        <div class="row">
            @forelse ($bookings as $booking)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-lg h-100">
                        <img src="{{ asset('storage/' . $booking->car->image_primary) }}" class="card-img-top"
                            alt="{{ $booking->car->model }}">
                        <div class="card-body">
                            <h5 class="card-title">🚗 {{ $booking->car->model }}</h5>
                            <p class="mb-1">👤 User : <strong>{{ $booking->user->name }}</strong></p>
                            <p class="mb-1">📦 Total Hari Disewa : {{ $booking->day }} <strong>Hari</strong></p>
                            {{-- <p class="mb-1">📍 Pickup: {{ $booking->pickup_latitude }}, {{ $booking->pickup_longitude }}
                            </p> --}}
                            <p class="mb-1">📍 Jarak Tempuh :
                                <strong>Km</strong>
                            </p>
                            <p class="mb-2">📦 Status Booking : <span
                                    class="badge bg-warning text-dark text-capitalize">{{ $booking->status }}</span></p>
                            <div class="d-flex gap-2 mt-4">
                                <form method="POST" action="{{ route('admin.bookings.approve', $booking->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success bnt-sm px-3 fw-bold">Acc Booking</button>
                                </form>
                                <form method="POST" action="{{ route('admin.bookings.reject', $booking->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger bnt-sm px-3 fw-bold">Rejected
                                        Booking</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Belum ada booking yang menunggu konfirmasi.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
