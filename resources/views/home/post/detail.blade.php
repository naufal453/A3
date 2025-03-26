@extends('layouts.app-master')

@section('content')
    <style>
        body {
            background-color: #fff5e4 !important;
            /* Use a specific class to avoid affecting the navbar */
        }
    </style>
    <div class="container">
        {{-- Post Details --}}
        <h1>{{ $post->title }}</h1>

        @if ($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="img-fluid"
                style="border-radius:10px;max-height: 700px;">
        @endif
        <br>
        <br>
        <p>{{ $post->description }}</p>
        <br>
        <small>Posted by {{ $post->user->username }} on {{ $post->created_at->format('M d, Y') }}</small>

        <hr>

        {{-- Chapters Section --}}
        <h2>Chapters</h2>
        @if ($chapters->isEmpty())
            <p>No chapters available for this post.</p>
        @else
            <ul>
                @foreach ($chapters as $chapter)
                    <li>
                        <a href="{{ route('chapters.show', $chapter->id) }}">{{ $chapter->title }}</a>

                        {{-- Check if the authenticated user is the owner of the chapter --}}
                        @if (auth()->id() === $chapter->user_id)
                            {{-- Edit Chapter Button --}}
                            <!-- <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editChapterModal{{ $chapter->id }}">Edit</button> -->

                            {{-- Delete Chapter Button --}}
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteChapterModal{{ $chapter->id }}">Delete</button>
                        @endif
                    </li>

                    {{-- Edit Chapter Modal --}}
                    <!-- @if (auth()->id() === $chapter->user_id)
    <div class="modal fade" id="editChapterModal{{ $chapter->id }}" tabindex="-1"
                                aria-labelledby="editChapterModalLabel{{ $chapter->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('chapters.update', $chapter->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editChapterModalLabel{{ $chapter->id }}">Edit
                                                    Chapter
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Chapter Title</label>
                                                    <input type="text" class="form-control" id="title" name="title"
                                                        value="{{ $chapter->title }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="content" class="form-label">Chapter Content</label>
                                                    <textarea class="form-control" id="content" name="content" rows="5" required>{{ $chapter->content }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
    @endif -->

                    {{-- Delete Chapter Modal --}}
                    @if (auth()->id() === $chapter->user_id)
                        <div class="modal fade" id="deleteChapterModal{{ $chapter->id }}" tabindex="-1"
                            aria-labelledby="deleteChapterModalLabel{{ $chapter->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('chapters.destroy', $chapter->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteChapterModalLabel{{ $chapter->id }}">Delete
                                                Chapter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete the chapter "{{ $chapter->title }}"?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </ul>
        @endif

        <hr>

        {{-- Comments Section --}}
        @include('layouts.partials.comments')
    </div>
@endsection
