@include('layouts.partials.navbar')
@extends('layouts.app-master')
<style>
    body {
        background-color: #fff5e4 !important;
        /* Use a specific class to avoid affecting the navbar */
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>story terarsip</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container position-absolute top-50 start-50 translate-middle"
        style="text-align: center;margin-top: 20px;">
        <h2>Story diarsipkan penulis</h2>
        <a href="{{ url('/') }}">Return to Home</a>
    </div>
</body>
