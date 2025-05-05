<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

<!-- Add Post Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="height: 700px;">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Story</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: calc(100% - 120px);">
                <form action="{{ url('posts') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Title input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                            maxlength="45" required />
                    </div>

                    <!-- Reference input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="reference" name="reference"
                            placeholder="Reference (optional)" maxlength="255" />
                    </div>

                    <!-- Genre input (as checkboxes or select) -->
                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre</label>
                        <div class="d-flex align-items-center gap-2">
                            <select class="form-select w-auto" id="genre" name="genre_select"
                                style="min-width: 180px;">
                                <option value="" disabled>Select genre</option>
                                <option value="Fantasy" selected>Fantasy</option>
                                <option value="Drama">Drama</option>
                                <option value="Action">Action</option>
                                <option value="Romance">Romance</option>
                                <option value="Comedy">Comedy</option>
                                <option value="Horror">Horror</option>
                                <option value="Sci-Fi">Sci-Fi</option>
                                <option value="Other">Other</option>
                                @foreach ($genres ?? [] as $genre)
                                    @if (!in_array($genre->name, ['Fantasy', 'Drama', 'Action', 'Romance', 'Comedy', 'Horror', 'Sci-Fi', 'Other']))
                                        <option value="{{ $genre->name }}">{{ $genre->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="mx-2">or</span>
                            <input type="text" class="form-control w-auto" id="genre_custom" name="genre_custom"
                                placeholder="Add new (max 10)" maxlength="10" style="min-width: 180px;" />
                        </div>
                    </div>

                    <style>
                        .genre-checklist {
                            background: #f8f9fa;
                            padding: 15px;
                            border-radius: 8px;
                            border: 1px solid #dee2e6;
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
                            gap: 10px;
                        }

                        .form-check-input:checked {
                            background-color: #0d6efd;
                            border-color: #0d6efd;
                        }
                    </style>

                    <!-- Quill Editor -->
                    <div id="quill-editor" style="height: 350px;"></div>
                    <input type="hidden" id="description" name="description">
                    <br>
                    <!-- Image upload with preview -->
                    <div class="input-group mb-3">
                        <input class="form-control" type="file" id="image" name="image" accept="image/*"
                            required onchange="previewImage(event)" />
                        <label class="input-group-text" for="image">Add Cover</label>
                    </div>
                    <div class="mb-3 text-center">
                        <img id="imagePreview" src="#" alt="Image Preview"
                            style="display: none; max-width: 100%; height: auto; border-radius: 10px;" />
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<!-- DOMPurify -->
<script src="https://cdn.jsdelivr.net/npm/dompurify@2.4.0/dist/purify.min.js"></script>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Write your content here...',
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    ['clean']
                ]
            }
        });

        var form = document.querySelector('form');
        form.addEventListener('submit', function() {
            var descriptionInput = document.querySelector('#description');
            var quillContent = quill.root.innerHTML;
            var sanitizedContent = DOMPurify.sanitize(quillContent);
            descriptionInput.value = sanitizedContent;
        });
    });
</script>
