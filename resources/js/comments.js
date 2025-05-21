document.addEventListener('DOMContentLoaded', function () {
    const commentForm = document.getElementById('comment-form');
    const commentsList = document.getElementById('comments-list');
    const noCommentsMessage = document.getElementById('no-comments');

    if (!commentForm || !commentsList) return;

    commentForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const submitButton = commentForm.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Posting...';

        const formData = new FormData(commentForm);
        const data = {
            content: formData.get('content'),
            post_id: formData.get('post_id')
        };

        try {
            const response = await fetch(commentForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                const newComment = await response.json();

                // Remove "No comments" message if present
                if (noCommentsMessage) {
                    noCommentsMessage.remove();
                }

                // Create new comment card element
                const commentCard = document.createElement('div');
                commentCard.classList.add('card', 'mb-3');
                commentCard.innerHTML = `
                    <div class="card-body">
                        <h5>${newComment.user.username} <span>(me)</span></h5>
                        <p>${newComment.content}</p>
                        <small>${new Date(newComment.created_at).toLocaleString()}</small>
                        <br>
                        <form action="/comments/${newComment.id}" method="POST" class="d-inline">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm" type="button" onclick="if(confirm('Are you sure you want to delete this comment?')) { this.form.submit(); }">Delete</button>
                        </form>
                    </div>
                `;

                // Append new comment to the top of the list
                commentsList.prepend(commentCard);

                // Clear reload timeout if set (prevents page reload)
                if (window.commentReloadTimeout) {
                    clearTimeout(window.commentReloadTimeout);
                    window.commentReloadTimeout = null;
                }
                if (window.commentSubmitBtn) {
                    window.commentSubmitBtn.disabled = false;
                }

                // Clear textarea
                commentForm.querySelector('textarea[name="content"]').value = '';
            } else {
                const errorData = await response.json();
                alert(errorData.message || 'Failed to post comment.');
            }
        } catch (error) {
            console.error('Error posting comment:', error);
            alert('An error occurred while posting the comment.');
        } finally {
            // submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        }
    });
});
