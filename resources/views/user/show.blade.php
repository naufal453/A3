@extends('layouts.app-master')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@section('content')
    <div class="p-5 rounded">
        <h1>{{ $user->username }}</h1>
        <h2>Timeline</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($user->posts as $post)
                <div class="col">
                    <div class="card h-100">
                        @if ($post->image_path)
                            <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="Post Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('home.post.detail', ['id' => $post->id]) }}" class="text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <p class="card-text">
                                {{ Str::limit($post->description, 150) }}
                            </p>
                            <button class="btn btn-link p-0" data-bs-toggle="modal"
                                data-bs-target="#viewPostModal{{ $post->id }}">Read More</button>
                            <br>
                            <small class="text-body-secondary">
                                Posted {{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}
                            </small>
                        </div>
                        @if (auth()->id() == $post->user_id)
                            <div class="card-footer d-flex justify-content-between">
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addChapterModal{{ $post->id }}">
                                    Add Chapter
                                </button>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editPostModal{{ $post->id }}">Edit</button>
                                <!-- Delete Story Button -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteStoryModal{{ $post->id }}">Delete</button>
                            </div>
                        @endif
                    </div>
                </div>
                @include('home.post.desc')
                @include('home.post.edit')
                <!-- Add Chapter Modal -->
                <div class="modal fade" id="addChapterModal{{ $post->id }}" tabindex="-1"
                    aria-labelledby="addChapterModalLabel{{ $post->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('chapters.store') }}">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addChapterModalLabel{{ $post->id }}">Add Chapter to
                                        "{{ $post->title }}"</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Chapter Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            minlength="9" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Chapter Content</label>
                                        <textarea class="form-control" id="content" name="content" rows="5" minlength="100" required></textarea>
                                    </div>
                                    <!-- Hidden input to pass the post ID -->
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Chapter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Delete Story Confirmation Modal -->
                <div class="modal fade" id="deleteStoryModal{{ $post->id }}" tabindex="-1"
                    aria-labelledby="deleteStoryModalLabel{{ $post->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteStoryModalLabel{{ $post->id }}">Delete Story</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete the story "{{ $post->title }}"? This action cannot be
                                    undone.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
