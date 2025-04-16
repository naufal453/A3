@auth
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="main-content">
        <div class="row align-items-start g-4">
            <div class="col-md-4 text-center">
                @if ($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image"
                        class="img-fluid book-cover mb-3 shadow-sm">
                @endif
                <div id="list-example mb-3" id="chapter-list" class="list-group sticky-top" style="top: 20px;">
                    <a class="list-group-item list-group-item-action shadow-sm" href="#chapters-section">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-book" viewBox="0 0 16 16">
                            <path
                                d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                        </svg> Chapters
                    </a>
                </div>
            </div>

            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 id="description-section">{{ $post->title }}</h3>
                        <h6 class="text-uppercase">by <strong>{{ $post->user->username }}</strong></h6>

                        <p>{{ $post->created_at->format('M d, Y') }}</p>
                    </div>
                    @if (auth()->check())
                        <div class="d-flex">
                            @php
                                $saved = auth()->user()->savedPosts->contains($post->id);
                            @endphp
                            <form action="{{ $saved ? route('posts.unsave', $post->id) : route('posts.save', $post->id) }}"
                                method="POST" class="me-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi {{ $saved ? 'bi-bookmark-check-fill' : 'bi-bookmark' }}"></i>
                                    <span class="ms-1">{{ $saved ? 'Saved' : 'Save' }}</span>
                                </button>
                            </form>

                            @can('archive', $post)
                                <form
                                    action="{{ $post->is_archived ? route('posts.unarchive', $post->id) : route('posts.archive', $post->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $post->is_archived ? 'btn-warning' : 'btn-outline-warning' }}">
                                        <i class="bi {{ $post->is_archived ? 'bi-archive-fill' : 'bi-archive' }}"></i>
                                        <span class="ms-1">{{ $post->is_archived ? 'Unarchive' : 'Archive' }}</span>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    @endif
                </div>


                <div class="post-description mb-5">
                    <div class="collapsed-description">
                        {!! Str::limit($post->description, 1000, '...') !!}
                        @if (strlen(strip_tags($post->description)) > 1000)
                            <a href="#" class="read-more-toggle btn btn-link p-0">Read More</a>
                        @endif
                    </div>
                    <div class="full-description d-none">
                        {!! $post->description !!}
                        <a href="#" class="read-less-toggle btn btn-link p-0">Read Less</a>
                    </div>
                </div>




                <div class="d-flex align-items-center mt-3">
                    @if (auth()->check())
                        @php
                            $liked = $post->likes->contains('user_id', auth()->id());
                        @endphp
                        <div class="d-flex align-items-center">
                            <button id="like-button" class="btn {{ $liked ? 'btn-danger' : 'btn-primary' }} me-2"
                                data-liked="{{ $liked ? 'true' : 'false' }}" data-post-id="{{ $post->id }}">
                                <i id="like-icon"
                                    class="bi {{ $liked ? 'bi-hand-thumbs-down-fill' : 'bi-hand-thumbs-up-fill' }}"></i>
                                <span id="like-text">{{ $liked ? 'Dislike' : 'Like' }}</span>
                            </button>

                            <p id="like-count" class="mb-0">{{ $post->likes->count() }}
                                {{ Str::plural('like', $post->likes->count()) }}</p>
                        </div>
                    @endif
                </div>

                <hr id="chapters-section">
                <h4>Chapters</h4>
                @if ($chapters->isEmpty())
                    <p>No chapters available for this post.</p>
                @else
                    <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true"
                        class="scrollspy-example overflow-auto" tabindex="0" style="height: 150px;">
                        <ul class="list-group list-group-flush mb-5">
                            @foreach ($chapters as $chapter)
                                <li class="list-group-item bg-transparent border-0">
                                    Chapter {{ $loop->iteration }}:
                                    <a href="{{ route('chapters.show', $chapter->id) }}">{{ $chapter->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <hr id="comments-section">
                @include('layouts.partials.comments')
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/description-toggle.js') }}"></script>
    @endpush

@endauth
