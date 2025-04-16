<div class="modal fade" id="addChapterModal{{ $post->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="addChapterModalLabel{{ $post->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('chapters.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addChapterModalLabel{{ $post->id }}">Add Chapter to
                        "{{ $post->title }}"</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height: calc(100% - 120px);">
                    <div class="mb-3">
                        <label for="title" class="form-label">Chapter Title</label>
                        <input type="text" class="form-control" id="title" name="title" minlength="9"
                            maxlength="60" style="height: 50px; resize: none;">
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
