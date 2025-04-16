@foreach ($post->chapters as $chapter)
    <div class="modal fade" id="deleteChapterModal{{ $chapter->id }}" tabindex="-1" aria-labelledby="deleteChapterModalLabel{{ $chapter->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('chapters.destroy', $chapter->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteChapterModalLabel{{ $chapter->id }}">Delete Chapter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete the chapter "{{ $chapter->title }}"? This action cannot be undone.
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