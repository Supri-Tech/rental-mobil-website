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
                        <a href="#" class="btn btn-success w-100">✅ Confirm Booking</a>
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
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map');

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Contoh destinasi di Jawa
            var destinations = [{
                    lat: -7.80303,
                    lng: 110.36196,
                    name: "Yogyakarta"
                },
                {
                    lat: -6.2088,
                    lng: 106.8456,
                    name: "Jakarta"
                },
                {
                    lat: -7.2575,
                    lng: 112.7521,
                    name: "Surabaya"
                },
                {
                    lat: -6.93245,
                    lng: 107.58911,
                    name: "Bandung"
                }
            ];

            destinations.forEach(function(dest) {
                L.marker([dest.lat, dest.lng])
                    .addTo(map)
                    .bindPopup('<b>Destination</b><br />' + dest.name);
            });

            // Fokus peta ke Pulau Jawa
            var jawaBounds = L.latLngBounds(
                [-8.8, 105.0], // Southwest (dekat Ujung Kulon)
                [-5.5, 114.0] // Northeast (dekat Surabaya)
            );
            map.fitBounds(jawaBounds);

            // Marker untuk user klik
            var userMarker;
            map.on('click', function(e) {
                if (!userMarker) {
                    userMarker = L.marker(e.latlng).addTo(map);
                } else {
                    userMarker.setLatLng(e.latlng);
                }

                userMarker.bindPopup("Your destination: " + e.latlng.lat.toFixed(5) + ", " + e.latlng.lng
                        .toFixed(5))
                    .openPopup();

                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            });
        });
    </script>

@endsection
