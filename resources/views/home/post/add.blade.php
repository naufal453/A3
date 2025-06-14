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
                            placeholder="Reference" maxlength="255" required />
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
                                <option value="Thriller">Thriller</option>
                                <option value="Other">Other</option>
                                @foreach ($genres ?? [] as $genre)
                                    @if (
                                        !in_array($genre->name, [
                                            'Fantasy',
                                            'Drama',
                                            'Action',
                                            'Romance',
                                            'Comedy',
                                            'Horror',
                                            'Sci-Fi',
                                            'Thriller',
                                            'Other',
                                        ]))
                                        <option value="{{ $genre->name }}">{{ $genre->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            {{-- <span class="mx-2">or</span>
                            <input type="text" class="form-control w-auto" id="genre_custom" name="genre_custom"
                                placeholder="Add new (max 10)" maxlength="10" style="min-width: 180px;" /> --}}
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
                    <div id="quill-container"></div>
                    <input type="hidden" id="description" name="description">
                    <div id="content-warning" class="text-danger mt-2"></div>
                    <div id="content-counter" class="text-muted mt-2"></div>
                    <br>
                    <!-- Image upload with preview -->
                    <div class="input-group mb-3">
                        <input class="form-control" type="file" id="image" name="image" accept="image/*"
                            required onchange="handleImageChange(event)" />
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
<script src="https://unpkg.com/browser-image-compression/dist/browser-image-compression.js"></script>

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

    async function handleImageChange(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');

        if (!input.files.length) {
            preview.src = '#';
            preview.style.display = 'none';
            return;
        }

        let file = input.files[0];

        // Only compress if image is larger than 1MB
        if (file.size > 1 * 1024 * 1024) {
            const options = {
                maxSizeMB: 1,
                maxWidthOrHeight: 1200,
                useWebWorker: true
            };
            try {
                file = await imageCompression(file, options);

                // Replace the file in the input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
            } catch (error) {
                console.error('Image compression error:', error);
            }
        }

        // Show the (compressed or original) image in the preview
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const hiddenInput = document.getElementById('description');
        const warningEl = document.getElementById('content-warning');
        const counterEl = document.getElementById('content-counter');
        const form = document.querySelector('form');

        // Create the editor div dynamically
        const editorDiv = document.createElement('div');
        editorDiv.style.height = '350px';
        document.getElementById('quill-container').appendChild(editorDiv);

        // Initialize Quill
        var quill = new Quill(editorDiv, {
            theme: 'snow',
            placeholder: 'Write your content here...',
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['link'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
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
            e.preventDefault();

            const plainText = quill.getText().trim();
            const length = plainText.length;

            if (length === 0) {
                warningEl.textContent = 'Content cannot be empty.';
                return;
            }

            if (length > 1000) {
                warningEl.textContent = 'Content exceeds 1000 characters.';
                return;
            }

            warningEl.textContent = '';

            var quillContent = quill.root.innerHTML;
            var sanitizedContent = DOMPurify.sanitize(quillContent);
            hiddenInput.value = sanitizedContent;

            // Now submit the form programmatically
            form.submit();
        });
    });
</script>
