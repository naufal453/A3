<!-- Edit Post Modal -->
<div class="modal fade" id="editPostModal{{ $post->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="editPostModalLabel{{ $post->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editPostModalLabel{{ $post->id }}">Edit Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('posts.update', $post->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Title input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $post->title }}" required />
                    </div>

                    <!-- Content textarea -->
                    <div class="mb-3">
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $post->description }}</textarea>
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
