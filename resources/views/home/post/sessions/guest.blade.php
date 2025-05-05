@guest
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Guest Action Modal -->
    <div class="modal fade" id="guestActionModal" tabindex="-1" aria-labelledby="guestActionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guestActionModalLabel">Action Requires Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>This action requires an account. Please sign up or log in to continue.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Reading</button>
                    <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Log In</a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="row align-items-start g-4">
            @include('home.post.sessions.partial')

            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 id="description-section">{{ $post->title }}</h3>
                        <h6 class="text-uppercase">by <strong>{{ $post->user->username }}</strong></h6>

                        <p>{{ $post->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal"
                            data-bs-target="#guestActionModal">
                            <i class="bi bi-bookmark"></i>
                            <span class="ms-1">Save</span>
                        </button>

                    </div>
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
                    <button id="like-button" class="btn btn-primary me-2" data-bs-toggle="modal"
                        data-bs-target="#guestActionModal">
                        <i class="bi bi-hand-thumbs-up-fill"></i>
                        <span>{{ $post->likes->count() }}</span>
                    </button>
                    {{--
                    <p id="like-count" class="mb-0">{{ $post->likes->count() }}
                    </p> --}}
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
                                <li class="list-group-item bg-transparent border-0" style="list-style: none">
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
        <script>
            // Initialize Bootstrap modal
            document.addEventListener('DOMContentLoaded', function() {
                const guestActionModal = new bootstrap.Modal(document.getElementById('guestActionModal'));
            });
        </script>
    @endpush

@endguest
