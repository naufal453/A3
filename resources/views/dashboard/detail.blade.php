<div class="modal fade" data-bs-backdrop="static" id="chapterListModal{{ $post->id }}" tabindex="-1"
    aria-labelledby="chapterListModalLabel{{ $post->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chapterListModalLabel{{ $post->id }}">{{ $post->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; margin: 10px;">
                <img src="{{ asset('storage/' . $post->image_path) }}" class="rounded me-3" alt="Post Image"
                    style="width: 200px; object-fit: cover;">
                <br>
                <br>
                @php
                    $description = strip_tags(html_entity_decode($post->description));
                @endphp
                @if (strlen($description) > 90)
                    <p class="mb-1 text-muted">
                        <span class="short-description">{{ Str::limit($description, 90) }}</span>
                        <span class="full-description d-none">{{ $description }}</span>
                        <a href="javascript:void(0);" class="read-more-less text-primary"
                            onclick="toggleDescription(this)">Read More</a>
                    </p>
                @else
                    <p class="mb-1 text-muted">{{ $description }}</p>
                @endif

                <script>
                    function toggleDescription(element) {
                        const shortDesc = element.previousElementSibling.previousElementSibling;
                        const fullDesc = element.previousElementSibling;
                        if (shortDesc.classList.contains('d-none')) {
                            shortDesc.classList.remove('d-none');
                            fullDesc.classList.add('d-none');
                            element.textContent = 'Read More';
                        } else {
                            shortDesc.classList.add('d-none');
                            fullDesc.classList.remove('d-none');
                            element.textContent = 'Read Less';
                        }
                    }
                </script>
            </div>
            <hr>
            <div class="modal-body" data-bs-spy="scroll" data-bs-target="#chapterListNav{{ $post->id }}"
                data-bs-offset="0" tabindex="0">

                @if ($post->chapters->isEmpty())
                    <p class="text-muted">No chapters available for this story.</p>
                @else
                    <!-- Scrollable Chapter List -->
                    <ul class="list-group" style="list-style-type:none; padding-left:0;">
                        @foreach ($post->chapters as $chapter)
                            <li id="chapter{{ $chapter->id }}"
                                class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <strong>Chapter {{ $loop->iteration }}: {{ $chapter->title }}</strong>
                                    <br>
                                    <small class="text-muted">Last updated:
                                        {{ \Carbon\Carbon::parse($chapter->updated_at)->diffForHumans() }}</small>
                                </span>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('chapters.show', $chapter->id) }}"
                                        class="btn btn-primary btn-sm me-1">View</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteChapterModal{{ $chapter->id }}">Delete</button>
                                </div>
                            </li>
                        @endforeach
                    </ul>


                @endif
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end w-100">
                    <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#addChapterModal{{ $post->id }}">Add Chapter</button>
                </div>
            </div>
        </div>
    </div>
</div>
