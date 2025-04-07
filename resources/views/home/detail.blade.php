@extends('layouts.app-master')

@section('content')
    <style>
        body {
            background-color: #fff5e4 !important;
        }

        .sidebar {
            margin-top: 80px;
            margin-bottom: 200px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 20%;
            background-color: #f6e3c2;
            padding: 25px;
            overflow-y: auto;
            display: flex;
            /* Enables Flexbox */
            flex-direction: column;
            /* Aligns items vertically */
            align-items: center;
            /* Centers items horizontally */
            justify-content: flex-start;
            /* Aligns items at the top */
        }

        .sidebar h5 {
            text-align: center;
            margin-bottom: 20px;
            /* Adds spacing between elements */
        }

        .sidebar p {

            margin-bottom: 20px;
            /* Adds spacing between elements */
        }

        .main-content {
            margin-left: 15%;
            /* Matches the width of the sidebar */
            margin-right: 30px;
            /* Adds margin to the right to prevent text from touching the edge */
            padding: 20px;
        }

        .post-description {
            margin-right: 30px;
            /* Consistent margin for the description */
            line-height: 1.6;
            /* Improves readability */
            word-wrap: break-word;
            /* Ensures long words break to the next line */
            max-width: 60ch;
            /* Limits the text to approximately 100 characters per line */
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="sidebar">
        <h5>
            <svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" fill="currentColor"
                class="bi bi-person-square me-2" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                <path
                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
            </svg>
            <a href="{{ route('user.show', ['username' => $post->user->username]) }}" class="user-link">
                {{ $post->user->username }}
            </a>
        </h5>
        <p>Created {{ $post->created_at->format('M d, Y') }}</p>
        <br>
        <h4>Chapters</h4>
        @if ($chapters->isEmpty())
            <p>No chapters available for this post.</p>
        @else
            <ul class="list-group list-group-flush" style="margin-bottom: 100px;">
                @foreach ($chapters as $chapter)
                    <li class="list-group-item" style="background-color: transparent; border: none;">
                        <p style="text-align: start; margin-bottom: 0;">
                            <a href="{{ route('chapters.show', $chapter->id) }}">{{ $chapter->title }}</a>
                        </p>
                        {{-- Check if the authenticated user is the owner of the chapter --}}
                        @if (auth()->id() === $chapter->user_id)
                            {{-- Delete Chapter Button --}}
                            <button type="button" class="btn btn-danger btn-sm mt-2"
                                onclick="showConfirmation({{ $chapter->id }}, '{{ $chapter->title }}')">
                                Delete
                            </button>

                            {{-- Hidden Form for Deletion --}}
                            <form id="delete-form-{{ $chapter->id }}" method="POST"
                                action="{{ route('chapters.destroy', $chapter->id) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="main-content">
        {{-- Post Details --}}
        <h1>{{ $post->title }}</h1>

        @if ($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="img-fluid"
                style="border-radius:10px; max-height: 450px;">
        @endif
        <br>
        <br>
        <p class="post-description">{{strip_tags(html_entity_decode($post->description)) }}</p>
        <br>

        <hr>
        <p id="like-count">{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</p>
        @if (auth()->check())
            @php
                $liked = $post->likes->contains('user_id', auth()->id());
            @endphp

            <button id="like-button" class="btn {{ $liked ? 'btn-danger' : 'btn-primary' }}"
                data-liked="{{ $liked ? 'true' : 'false' }}" data-post-id="{{ $post->id }}">
                <i class="bi {{ $liked ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up' }}"></i>
                <span id="like-text">{{ $liked ? 'Dislike' : 'Like' }}</span>
            </button>
        @endif

        <hr>


        {{-- Comments Section --}}
        @include('layouts.partials.comments')
    </div>
@endsection
<script src="{{ asset('js/like-button.js') }}"></script>
<script>
    function showConfirmation(chapterId, chapterTitle) {
        // Create a custom confirmation dialog
        const confirmation = confirm(`Are you sure you want to delete the chapter "${chapterTitle}"?`);

        if (confirmation) {
            // Submit the hidden form if the user confirms
            document.getElementById(`delete-form-${chapterId}`).submit();
        }
    }
</script>
