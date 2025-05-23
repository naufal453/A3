@include('layouts.partials.navbar')
@include('layouts.app')
<style>
    body {
        background-color: #fff5e4 !important;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container position-absolute top-50 start-50 translate-middle"
        style="text-align: center; margin-top: 20px;">
        @if (isset($errorType) && $errorType === 'post')
            <h2>Postnya gak ada</h2>
        @elseif (isset($errorType) && $errorType === 'user')
            <h2>Usernya gak ada</h2>
        @else
            @guest
                <div class="alert alert-danger mt-3">
                    <h2>Halaman tidak ditemukan</h2>
                    <p>Silakan login untuk akses lebih lanjut.</p>
                </div>
            @else
                <div class="alert alert-danger mt-3">
                    <h2>Halaman tidak ditemukan</h2>
                    <p>Maaf, halaman yang Anda cari tidak tersedia.</p>
                </div>
            @endguest
        @endif
        <a href="{{ url('/') }}">Return to Home</a>
    </div>
</body>
