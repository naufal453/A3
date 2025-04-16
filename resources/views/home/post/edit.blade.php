<!-- Include Quill.js -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Edit Post Modal -->
<div class="modal fade" id="editPostModal{{ $post->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="editPostModalLabel{{ $post->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editPostModalLabel{{ $post->id }}">Edit Story</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('posts.update', $post->id) }}" method="POST" id="editForm{{ $post->id }}">
                    @csrf
                    @method('PUT')

                    <!-- Title input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" name="title" value="{{ $post->title }}"
                            maxlength="45" required />
                    </div>

                    <!-- Quill editor -->
                    <div class="mb-3">
                        <div id="editor{{ $post->id }}" style="height: 200px;">
                            {!! $post->description !!}
                        </div>
                        <input type="hidden" name="description" id="description{{ $post->id }}">
                    </div>

                    <!-- Submit button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quill Initialization Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quill{{ $post->id }} = new Quill('#editor{{ $post->id }}', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [2, 3, false]
                    }],
                    ['bold', 'italic'],
                    ['link', 'blockquote'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                ]
            }
        });

        // On form submit, copy Quill content to hidden input
        const form{{ $post->id }} = document.querySelector('#editForm{{ $post->id }}');
        form{{ $post->id }}.addEventListener('submit', function() {
            const html = quill{{ $post->id }}.root.innerHTML;
            document.querySelector('#description{{ $post->id }}').value = html;
        });
    });
</script>
