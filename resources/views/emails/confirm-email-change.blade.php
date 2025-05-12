<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Perubahan Email</title>
</head>
<body>
    <p>Halo, {{ Auth::user()->name }}!</p>
    <p>Anda telah meminta untuk mengubah email Anda dari <strong>{{ $email_lama }}</strong> menjadi <strong>{{ $email_baru }}</strong>.</p>
    <p>Silakan klik link berikut untuk mengonfirmasi perubahan email Anda:</p>
    <a href="{{ $link }}">{{ $link }}</a>
    <p>Jika Anda tidak merasa melakukan perubahan ini, abaikan email ini.</p>
</body>
</html>
