document.addEventListener('DOMContentLoaded', function () {
    const commentForm = document.getElementById('comment-form');
    const commentsList = document.getElementById('comments-list');
    const noCommentsMessage = document.getElementById('no-comments');

    commentForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(commentForm);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(commentForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove "No comments yet" message if present
                    if (noCommentsMessage) {
                        noCommentsMessage.remove();
                    }

                    // Append the new comment to the comments list
                    const newComment = document.createElement('div');
                    newComment.classList.add('card', 'mb-3');
                    newComment.id = `comment-${data.comment.id}`;
                    newComment.innerHTML = `
                        <div class="card-body">
                            <h5>${escapeHTML(data.comment.user.username)} ${
                        data.comment.user.id === data.auth_user_id ? '<span>(me)</span>' : ''
                    }</h5>
                            <p>${escapeHTML(data.comment.content)}</p>
                            <small>${escapeHTML(data.comment.created_at)}</small>
                            <br>
                            ${
                                data.comment.user.id === data.auth_user_id
                                    ? `<button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal${data.comment.id}">
                                        Delete
                                    </button>
                                    <div class="modal fade" id="deleteModal${data.comment.id}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel${data.comment.id}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel${data.comment.id}">Confirm Delete</h5>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this comment?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="/comments/${data.comment.id}" method="POST" class="d-inline">
                                                        <input type="hidden" name="_token" value="${csrfToken}">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`
                                    : ''
                            }
                        </div>
                    `;
                    commentsList.appendChild(newComment);

                    // Clear the form
                    commentForm.reset();
                } else {
                    alert('Failed to add comment. Please try again.');
                }
            })
            .catch(error => console.error('Error:', error));
    });
});

function escapeHTML(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}