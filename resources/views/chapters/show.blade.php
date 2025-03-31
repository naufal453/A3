<!-- filepath: c:\Users\TB\Documents\GitHub\Tech-Forum\resources\views\chapters\show.blade.php -->
@extends('layouts.app-master')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@section('content')
    <div class="container">
        <h1>{{ $chapter->title }}</h1>
        <p>{{ $chapter->content }}</p>
        <small>Posted by {{ $chapter->user->username ?? 'Unknown User' }} on
            {{ $chapter->created_at->format('M d, Y') }}</small>
    </div>
@endsection
