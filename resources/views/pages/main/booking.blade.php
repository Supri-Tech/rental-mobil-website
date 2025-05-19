@extends('layouts.main')

@section('title', 'Booking')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Booking for: {{ $car->model }}</h2>

        <div class="row">
            <!-- Car Details -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <img src="{{ asset('storage/' . $car->image_primary) }}" class="card-img-top rounded-top"
                        alt="{{ $car->model }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->model }}</h5>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item">🚗 Passenger Capacity: {{ $car->passenger_capacity }}</li>
                            <li class="list-group-item">⛽ Fuel Type: {{ $car->fuel_type }}</li>
                            <li class="list-group-item">📅 Year: {{ $car->year }}</li>
                            <li class="list-group-item">⚙️ Transmission: {{ $car->transmission }}</li>
                            <li class="list-group-item">🛣️ Mileage: {{ $car->mileage }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Map Destination -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header text-white">
                        <h5 class="mb-0">📍 Pick-up Destination</h5>
                    </div>
                    <div class="card-body p-0">
                        <div id="map" style="height: 400px;" class="rounded-bottom"></div>
                    </div>
                    <form method="POST" action="{{ route('booking.store', $car->id) }}">
                        @csrf
                        <label for="day" class="form-label">Sewa Berapa Hari</label>
                        <input type="number" id="day" class="form-control" name="day"
                            placeholder="Sewa Berapa Hari">
                        <input type="hidden" name="pickup_latitude" id="latitude">
                        <input type="hidden" name="pickup_longitude" id="longitude">
                        <input type="hidden" name="distance" id="distance">
                        <button type="submit" class="btn btn-success w-100 mt-4">✅ Confirm Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([-7.80303, 110.36196], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var startPoint = L.latLng(-7.634705, 111.5259826);
            L.marker(startPoint).addTo(map).bindPopup("Lokasi Anda Sekarang").openPopup();

            var destinationMarker;

            map.on('click', function(e) {
                var endPoint = e.latlng;

                // Tambahkan / update marker tujuan
                if (!destinationMarker) {
                    destinationMarker = L.marker(endPoint).addTo(map);
                } else {
                    destinationMarker.setLatLng(endPoint);
                }

                // Hitung jarak (meter → km)
                var distanceMeters = startPoint.distanceTo(endPoint);
                var distanceKm = (distanceMeters / 1000).toFixed(2);

                // Tampilkan info jarak di marker
                destinationMarker.bindPopup(
                    "Titik Tujuan<br>" +
                    // "Latitude: " + endPoint.lat.toFixed(5) + "<br>" +
                    // "Longitude: " + endPoint.lng.toFixed(5) + "<br>" +
                    "Jarak ke Pool: " + distanceKm + " km"
                ).openPopup();

                // (Opsional) Simpan ke input hidden untuk submit
                document.getElementById('latitude').value = endPoint.lat;
                document.getElementById('longitude').value = endPoint.lng;
                document.getElementById('distance').value = distanceKm, "Km";
            });
        });
    </script>

@endsection
