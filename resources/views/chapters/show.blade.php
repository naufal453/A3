<!-- filepath: c:\Users\TB\Documents\GitHub\Tech-Forum\resources\views\chapters\show.blade.php -->

@extends('layouts.app-master')

<link rel="stylesheet" href="{{ asset('css/show.css') }}">

@section('content')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">

    <div class="row align-items-start g-4">
        <div class="col-md-4 text-center">
            @if ($post->image_path)
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image"
                    class="img-fluid book-cover mb-3 shadow-sm">
            @endif
            <h5 id="description-section">{{ $post->title }}</h5>
            <div class="d-flex justify-content-center">
                <a href="#chapters-section"
                    class="btn btn-light d-inline-flex align-items-center gap-2 px-3 py-2 rounded-1 shadow-sm"
                    onclick="window.location='{{ route('home.post.detail', ['id' => $post->id]) }}'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                    </svg>
                    Back to story
                </a>
            </div>
        </div>
        <div class="col-md-8">
            <br>
            <h3>{{ $chapter->title }}</h3>
            <hr>
            <div class="post-description mb-5">

                <div class="collapsed-description">
                    {!! Str::limit($chapter->content, 1000, '...') !!}
                    @if (strlen(strip_tags($chapter->content)) > 1000)
                        <a href="#" class="read-more-toggle btn btn-link p-0">Read More</a>
                    @endif
                </div>

                @if (strlen(strip_tags($chapter->content)) > 1000)
                    <div class="full-description d-none">
                        {!! $chapter->content !!}
                        <a href="#" class="read-less-toggle btn btn-link p-0">Read Less</a>
                    </div>
                @endif
            </div>
        </div>
        @push('scripts')
            <script src="{{ asset('js/description-toggle.js') }}"></script>
        @endpush
        {{-- <div class="container">
        <h1>{{ $chapter->title }}</h1>
        <p>{!! $chapter->content !!}</p> <!-- Render HTML content -->
        <small>Posted by {{ $chapter->user->username ?? 'Unknown User' }} on
            {{ $chapter->created_at->format('M d, Y') }}</small>
    </div> --}}
    @endsection
