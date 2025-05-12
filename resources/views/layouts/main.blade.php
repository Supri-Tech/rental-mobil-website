<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Main Page')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/lib/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}">

    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- SweetAlert2 css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>

<body>

    @include('partials.main.spinner')
    @include('partials.main.topbar')
    @include('partials.main.navbar-hero')

    @yield('content') <!-- Konten Dashboard -->


    @include('partials.main.footer')

    <!-- Modal Pembaruan Profil -->
    @include('partials.main.profile-update') <!-- Menyertakan Modal Pembaruan Profil -->

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('error') }}',
                    text: 'Error !!',
                    confirmButtonColor: '#d33'
                });
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($showUpdateModal)
                // Tampilkan modal
                var profileModal = new bootstrap.Modal(document.getElementById('profileUpdateModal'));
                profileModal.show();

                // Hapus parameter dari URL
                const url = new URL(window.location.href);
                url.searchParams.delete('showUpdateModal');
                window.history.replaceState({}, document.title, url.toString());
            @endif
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.pathname === "/user/profile") {
                // Buka dropdown otomatis
                const pemesananDropdown = document.getElementById('pemesananDropdown');
                const profilDropdown = document.getElementById('profilDropdown');
                const bantuanDropdown = document.getElementById('bantuanDropdown');

                if (pemesananDropdown) {
                    pemesananDropdown.classList.add('show');
                }
                if (profilDropdown) {
                    profilDropdown.classList.add('show');
                }
                if (bantuanDropdown) {
                    bantuanDropdown.classList.add('show');
                }
            }
        });
    </script>
</body>

</html>
