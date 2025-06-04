<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #fff5e4 !important;
        }
    </style>
</head>

<body>

    @include('layouts.partials.navbar')
    @include('layouts.app')

    <div class="container position-absolute top-50 start-50 translate-middle text-center" style="margin-top: 20px;">
        @if (isset($errorType))
            @if ($errorType === 'post' && auth()->guest())
                <h2>Postnya gak ada</h2>
            @elseif ($errorType === 'user' && auth()->guest())
                <h2>Usernya gak ada</h2>
            @elseif ($errorType === 'post')
                <h2>Postnya gak ada</h2>
            @elseif ($errorType === 'user')
                <h2>Usernya gak ada</h2>
            @endif
        @else
            <h2>Halaman tidak ditemukan</h2>
        @endif

        <a href="{{ url('/') }}">Return to Home</a>
    </div>

</body>

</html>
