@extends('layouts.app-master')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@section('content')
    <div class="content-area p-5 rounded">
        @include('user.user')
        @include('user.guest')
    </div>
@endsection
