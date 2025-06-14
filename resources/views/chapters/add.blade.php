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
                            maxlength="60" style="height: 50px; resize: none;" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Chapter Content</label>
                        <div id="quill-container-{{ $post->id }}"></div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const postId = "{{ $post->id }}";
        const quillContainer = document.getElementById(`quill-container-${postId}`);
        const hiddenInput = document.getElementById(`content-${postId}`);
        const warningEl = document.getElementById(`content-warning-${postId}`);
        const counterEl = document.getElementById(`content-counter-${postId}`);
        const form = quillContainer.closest('form');

        // Create and attach editor
        const editorDiv = document.createElement('div');
        editorDiv.style.height = '300px';
        quillContainer.appendChild(editorDiv);

        const quill = new Quill(editorDiv, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'align': []
                    }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        // Character counter and hidden input update
        quill.on('text-change', function() {
            const plainText = quill.getText().trim();
            const length = plainText.length;

            hiddenInput.value = quill.root.innerHTML.trim(); // store full content
            counterEl.textContent = `${length}/1000 characters`;

            if (length > 1000) {
                counterEl.classList.add('text-danger');
            } else {
                counterEl.classList.remove('text-danger');
            }
        });

        // Form validation on submit
        form.addEventListener('submit', function(e) {
            const plainText = quill.getText().trim();
            const length = plainText.length;

            if (length === 0) {
                e.preventDefault();
                warningEl.textContent = 'Content cannot be empty.';
                return;
            }

            if (length > 1000) {
                e.preventDefault();
                warningEl.textContent = 'Content exceeds 1000 characters.';
                return;
            }

            warningEl.textContent = '';
        });
    });
</script>
