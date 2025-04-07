@extends('layouts.app-master')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@section('content')
    <div class="p-5 rounded">
        <h2>
            @if (auth()->id() === $user->id)
                Dashboard
            @else
                Author: {{ $user->username }}
            @endif
        </h2>
        <hr>
        <div class="row mb-4">
            <!-- Left Chart -->
            <div class="col-md-6" style="height: 200px;">
                <canvas id="userStatsChart" width="400" height="200"></canvas>
            </div>

            <!-- Right Chart -->
            <div class="col-md-6" style="height: 200px;">
                <canvas id="totalStatsChart" width="400" height="200"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Left Chart: Individual Post Stats
                const ctxLeft = document.getElementById('userStatsChart').getContext('2d');
                const posts = @json($user->posts->map(fn($post) => [
                    'title' => $post->title,
                    'likes' => $post->likes->count(),
                    'comments' => $post->comments->count()
                ])->sortByDesc(fn($post) => $post['likes'] + $post['comments'])->take(3)->values());

                const postTitles = posts.map(post => post.title);
                const likeCounts = posts.map(post => post.likes);
                const commentCounts = posts.map(post => post.comments);

                new Chart(ctxLeft, {
                    type: 'polarArea', // Polar Area Chart
                    data: {
                        labels: postTitles,
                        datasets: [
                            {
                                label: 'Likes',
                                data: likeCounts,
                                backgroundColor: [
                                    'rgba(75, 192, 192, 0.6)',
                                    'rgba(153, 102, 255, 0.6)',
                                    'rgba(255, 159, 64, 0.6)'
                                ],
                                borderColor: [
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        }
                    }
                });

                // Right Chart: Total Likes and Comments
                const ctxRight = document.getElementById('totalStatsChart').getContext('2d');
                const totalLikes = likeCounts.reduce((sum, count) => sum + count, 0);
                const totalComments = commentCounts.reduce((sum, count) => sum + count, 0);

                new Chart(ctxRight, {
                    type: 'doughnut',
                    data: {
                        labels: ['Total Likes', 'Total Comments'],
                        datasets: [{
                            data: [totalLikes, totalComments],
                            backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)'],
                            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        }
                    }
                });
            });
        </script>
        <hr>
        @if ($user->posts->isEmpty())
            <!-- Message when there are no posts -->
            <div class="text-center">
                <p class="text-muted">You have no story at all.</p>
            </div>
        @else
            <!-- Display posts -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($user->posts as $post)
                    <div class="col">
                        <div class="card h-100 d-flex flex-row align-items-center p-3">
                            @if ($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}" class="rounded me-3" alt="Post Image" style="width: 160px; height: 160px; object-fit: cover;">
                            @else
                                <div class="rounded bg-secondary me-3" style="width: 80px; height: 80px;"></div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('home.post.detail', ['id' => $post->id]) }}" class="text-decoration-none text-dark">
                                        {{Str::limit($post->title,20) }}
                                    </a>
                                </h6>
                                <p style="font-size: 0.9em;" class="mb-1 text-muted">{{ Str::limit(strip_tags(html_entity_decode($post->description)), 20) }}</p>
                                <small style="font-size: 0.8em;" class="text-body-secondary">Posted {{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}</small>
                            </div>
                            @if (auth()->id() == $post->user_id)
                                <div class="ms-3 d-flex flex-column">
                                    <span style="display: flex; align-items: center; gap: 5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                                            <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                                        </svg>
                                        <span>{{ $post->chapters->count() ?? 0 }}</span>
                                    </span>
                                    <span style="display: flex; align-items: center; gap: 5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                                            <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                                        </svg>
                                        <span>{{ $post->likes->count() ?? 0 }}</span>
                                    </span>
                                    <!-- Comments Count -->
                                    <span style="display: flex; align-items: center; gap: 5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                                            <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                                        </svg>
                                        <span>{{ $post->comments->count() ?? 0 }}</span>
                                    </span>
                                </div>
                                <div class="ms-3 d-flex flex-column">
                                    <button type="button" class="btn btn-success btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#addChapterModal{{ $post->id }}">Add Chapter</button>
                                    <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#editPostModal{{ $post->id }}">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStoryModal{{ $post->id }}">Delete</button>
                                </div>
                            @endif
                        </div>
                    </div>
                    @include('home.post.edit')
                    <!-- Add Chapter Modal -->
                    <div class="modal fade" id="addChapterModal{{ $post->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addChapterModalLabel{{ $post->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('chapters.store') }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addChapterModalLabel{{ $post->id }}">Add Chapter to "{{ $post->title }}"</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="overflow-y: auto; max-height: calc(100% - 120px);">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Chapter Title</label>
                                            <input type="text" class="form-control" id="title" name="title" minlength="9" maxlength="60" style="height: 50px; resize: none;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Chapter Content</label>
                                            <div id="quill-editor-{{ $post->id }}" style="height: 300px;"></div>
                                            <input type="hidden" id="content-{{ $post->id }}" name="content" maxlength="250" required>
                                            <div id="content-warning-{{ $post->id }}" class="text-danger mt-2"></div>
                                            <div id="content-counter-{{ $post->id }}" class="text-muted mt-2"></div>
                                        </div>
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit Chapter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Delete Story Confirmation Modal -->
                    <div class="modal fade" id="deleteStoryModal{{ $post->id }}" tabindex="-1" aria-labelledby="deleteStoryModalLabel{{ $post->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteStoryModalLabel{{ $post->id }}">Delete Story</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the story "{{ $post->title }}"? This action cannot be undone.
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
        @endif
    </div>
@endsection

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<!-- DOMPurify -->
<script src="https://cdn.jsdelivr.net/npm/dompurify@2.4.0/dist/purify.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const maxContentLength = 9000;

        @foreach ($user->posts as $post)
            var quill{{ $post->id }} = new Quill('#quill-editor-{{ $post->id }}', {
                theme: 'snow',
                placeholder: 'Write your chapter content here...',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        ['link', 'image'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['clean']
                    ]
                }
            });

            quill{{ $post->id }}.on('text-change', function(delta, oldDelta, source) {
                var contentLength = quill{{ $post->id }}.getText().trim().length;
                var warningElement = document.querySelector('#content-warning-{{ $post->id }}');
                var counterElement = document.querySelector('#content-counter-{{ $post->id }}');

                counterElement.textContent = `${contentLength}/${maxContentLength}`;

                if (contentLength > maxContentLength) {
                    quill{{ $post->id }}.deleteText(maxContentLength, contentLength);
                    warningElement.textContent = `Content is limited to ${maxContentLength} characters.`;
                } else {
                    warningElement.textContent = '';
                }
            });

            var form{{ $post->id }} = document.querySelector('#addChapterModal{{ $post->id }} form');
            form{{ $post->id }}.addEventListener('submit', function() {
                var contentInput = document.querySelector('#content-{{ $post->id }}');
                var quillContent = quill{{ $post->id }}.root.innerHTML;

                // Sanitize the Quill content using DOMPurify
                var sanitizedContent = DOMPurify.sanitize(quillContent);
                contentInput.value = sanitizedContent;
            });
        @endforeach
    });
</script>
