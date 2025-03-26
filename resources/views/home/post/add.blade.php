<!-- Add Post Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Story</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('posts') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Title input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                            required />
                    </div>

                    <!-- Content textarea -->
                    <div class="mb-3">
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Write your content here"
                            required></textarea>
                    </div>

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

                    <!-- Submit button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
</script>
