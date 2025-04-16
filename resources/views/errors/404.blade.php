<style>
    body {
        background-color: #fff5e4 !important;
        /* Use a specific class to avoid affecting the navbar */
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
        style="text-align: center;margin-top: 100px;">
        <h1>404 Not Found</h1>
        <h2>HAYOOO MAU BUKA APA</h2>
        <a href="{{ url('/') }}">Return to Home</a>
    </div>
</body>
