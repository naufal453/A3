<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alternate Arc Archive</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('icon/book.png') }}">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script>
        (function(m, a, z, e) {
            var s, t;
            try {
                t = m.sessionStorage.getItem('maze-us');
            } catch (err) {}

            if (!t) {
                t = new Date().getTime();
                try {
                    m.sessionStorage.setItem('maze-us', t);
                } catch (err) {}
            }

            s = a.createElement('script');
            s.src = z + '?apiKey=' + e;
            s.async = true;
            a.getElementsByTagName('head')[0].appendChild(s);
            m.mazeUniversalSnippetApiKey = e;
        })(window, document, 'https://snippet.maze.co/maze-universal-loader.js', '8ad8cd38-7725-47a9-b036-c96d9a1f114c');
    </script>
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

    @include('layouts.partials.navbar')

    <div class="container mt-5 pt-5">
        @yield('content')
    </div>

    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify@2.4.0/dist/purify.min.js"></script>

    <link href="{{ asset('css/scroll-to-top.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="{{ asset('js/scroll-to-top.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('js/notification.js') }}"></script>
</body>

</html>
