<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alternate Arc Archive</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('icon/book.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
</head>
@extends('layouts.app-master')

<body>
    <div id="app">

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
