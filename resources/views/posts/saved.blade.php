@extends('layouts.app-master')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">

@section('content')
    <div class="p-5 rounded" id="saved-posts-container">
        <h1>Saved Stories</h1>
        <hr>

        @if ($posts->isEmpty())
            <div class="text-center">
                <p class="text-muted">You have no saved posts.</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($posts as $post)
                    <div class="col">
                        <div class="card h-100 d-flex flex-row align-items-center p-3 position-relative shadow-sm rounded">
                            <!-- Dropdown Menu -->
                            <div class="dropdown position-absolute top-0 end-0 m-2">
                                <button class="btn" type="button" id="dropdownMenuButton{{ $post->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="shadow rounded dropdown-menu" style="min-width: 75px !important;"
                                    aria-labelledby="dropdownMenuButton{{ $post->id }}">
                                    <li>
                                        <form action="{{ route('posts.unsave', $post->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Remove</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            @if ($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}" class="rounded me-3" alt="Post Image"
                                    style="width: 100px; height: 160px; object-fit: cover;">
                            @else
                                <div class="rounded bg-secondary me-3" style="width: 80px; height: 80px;"></div>
                            @endif

                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('home.post.detail', $post->id) }}"
                                        class="text-decoration-none text-dark">
                                        {{ Str::limit($post->title, 20) }}
                                    </a>
                                </h6>
                                <p class="mb-1 text-muted" style="font-size: 0.9em;">
                                    {{ Str::limit(strip_tags(html_entity_decode($post->description)), 50) }}</p>

                            </div>

                            <div class="ms-3 d-flex flex-column">
                                <span class="d-flex align-items-center gap-1">
                                    <i class="bi bi-book"></i>
                                    <span>{{ $post->chapters->count() ?? 0 }}</span>
                                </span>
                                <span class="d-flex align-items-center gap-1">
                                    <i class="bi bi-hand-thumbs-up"></i>
                                    <span>{{ $post->likes->count() ?? 0 }}</span>
                                </span>
                                <span class="d-flex align-items-center gap-1">
                                    <i class="bi bi-chat"></i>
                                    <span>{{ $post->comments->count() ?? 0 }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $posts->links() }}
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // If opened in popup/modal, refresh parent and close
            if (window.opener) {
                window.opener.location.reload();
                window.close();
                return;
            }

            // Handle form submissions via AJAX
            const forms = document.querySelectorAll('form[action*="/posts/unsave"]');

            forms.forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const button = this.querySelector('button[type="submit"]');
                    const originalText = button.innerHTML;
                    button.disabled = true;
                    button.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status"></span> Updating...';

                    try {
                        const response = await fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        });

                        if (response.ok) {
                            // Remove the card from UI
                            this.closest('.col').remove();

                            // If no posts left, show empty message
                            if (document.querySelectorAll('.col').length === 0) {
                                document.querySelector('#saved-posts-container').innerHTML = `
                                <div class="text-center">
                                    <p class="text-muted">You have no saved posts.</p>
                                </div>
                            `;
                            }
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                });
            });
        });
    </script>
@endpush
