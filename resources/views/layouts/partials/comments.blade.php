<h3>Comments</h3>
<div class="comments-list" id="comments-list">
    @forelse($post->comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $comment->user->username }}
                    @if (Auth::id() === $comment->user_id)
                        <span>(me)</span>
                    @endif
                </h5>
                <p>{{ $comment->content }}</p>
                <small>{{ $comment->created_at->format('d M Y, H:i') }}</small>
                <br>
                {{-- Delete Button --}}
                @if (Auth::id() === $comment->user_id)
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal"
                        data-bs-target="#deleteModal{{ $comment->id }}">
                        Delete
                    </button>
                @endif

                {{-- Delete Confirmation Modal --}}
                <div class="modal fade" id="deleteModal{{ $comment->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel{{ $comment->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $comment->id }}">Confirm Delete</h5>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this comment?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p id="no-comments">No comments yet. Be the first to comment!</p>
    @endforelse
</div>

{{-- Add Comment Form --}}
<form id="comment-form" action="{{ route('comments.store') }}" method="POST" class="mt-4" style="margin-bottom: 100px;">
    @csrf
    <div class="mb-3">
        <label for="content" class="form-label">Add a Comment</label>
        <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
    </div>
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

{{-- Include External JavaScript --}}
<script src="{{ asset('js/comments.js') }}"></script>