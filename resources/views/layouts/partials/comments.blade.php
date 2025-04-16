<h3>Comments</h3>
<div class="comments-list" id="comments-list">
    @forelse($post->comments as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{!! $comment->user->username !!}
                    @if (Auth::id() === $comment->user_id)
                        <span>(me)</span>
                    @endif
                </h5>
                <p>{!! $comment->content !!}</p> <!-- Escape output -->
                <small>{{ $comment->created_at->format('d M Y, H:i') }}</small>
                <br>
                {{-- Delete Button --}}
                @if (Auth::id() === $comment->user_id)
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="button"
                            onclick="if(confirm('Are you sure you want to delete this comment?')) { this.form.submit(); }">
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p id="no-comments">No comments yet. Be the first to comment!</p>
    @endforelse
</div>

{{-- Add Comment Form --}}
<form id="comment-form" action="{{ route('comments.store') }}" method="POST" class="mt-4"
    style="margin-bottom: 100px;">
    @csrf
    <div class="mb-3">
        <label for="content" class="form-label">Add a Comment</label>
        <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
    </div>
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    @guest
        <button data-bs-toggle="modal" data-bs-target="#guestActionModal" type="submit"
            class="btn btn-primary">Submit</button>
    @endguest
    @auth
        <button type="submit" class="btn btn-primary">Submit</button>
    @endauth
</form>

{{-- Include External JavaScript --}}
<script src="{{ asset('js/comments.js') }}"></script>
