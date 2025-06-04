@auth
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="main-content">
        <div class="row align-items-start g-4">
            @include('home.post.sessions.partial')

            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 id="description-section">{!! preg_replace('/(.{15})/u', '$1<wbr>', e($post->title ?? 'Unknown Title')) !!}</h3>
                        <h6 class="text-uppercase">by <strong>{{ $post->user->username }}</strong></h6>

                        <p>{{ $post->created_at->format('M d, Y') }}</p>
                        @if (!empty($post->reference))
                            <p>Reference:
                                <a href="https://en.wikipedia.org/wiki/{{ urlencode($post->reference) }}" target="_blank"
                                    rel="noopener" class="wiki-link">
                                    <span class="badge bg-secondary">{{ $post->reference }}</span>
                                </a>
                                <br>
                        @endif
                        Genre:
                        @foreach (explode(',', $post->genre) as $genre)
                            <span class="badge bg-secondary">{{ trim($genre) }}</span>
                        @endforeach
                        </p>
                    </div>
                    @if (auth()->check())
                        <div class="d-flex">
                            @php
                                $saved = auth()->user()->savedPosts->contains($post->id);
                            @endphp
                            <form action="{{ $saved ? route('posts.unsave', $post->id) : route('posts.save', $post->id) }}"
                                method="POST" class="me-2">
                                @csrf
                                <button type="submit"
                                    class="btn btn-sm {{ $saved ? 'btn-secondary' : 'btn-outline-secondary' }}">
                                    <i class="bi {{ $saved ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
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
                <div id="chapters-section" class="d-flex align-items-center mt-3">
                    @if (auth()->check())
                        @php
                            $liked = $post->likes->contains('user_id', auth()->id());
                        @endphp
                        <div class="d-flex align-items-center">
                            <form action="{{ $liked ? route('posts.unlike', $post->id) : route('posts.like', $post->id) }}" method="POST" class="me-2">
                                @csrf
                                <button type="submit" class="btn {{ $liked ? 'btn-secondary' : 'btn-primary' }}">
                                    <i class="bi {{ $liked ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up' }}"></i>
                                    <span>{{ $post->likes->count() }}</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <hr>
                <h4>Chapters</h4>
                @if ($chapters->isEmpty())
                    <p>No chapters available for this Story.</p>
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

    <style>
        .wiki-link .badge.bg-secondary:hover,
        .wiki-link:hover .badge.bg-secondary {
            background-color: #1a73e8 !important;
            color: #fff !important;
            cursor: pointer;
            text-decoration: underline;
        }
    </style>

    @push('scripts')
        <script src="{{ asset('js/description-toggle.js') }}"></script>
    @endpush

@endauth
