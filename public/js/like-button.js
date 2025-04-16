
document.addEventListener('DOMContentLoaded', function () {
    const likeButton = document.getElementById('like-button');
    const likeCount = document.getElementById('like-count');
    const likeText = document.getElementById('like-text');
    const likeIcon = document.getElementById('like-icon');

    if (likeButton) {
        likeButton.addEventListener('click', function () {
            const postId = likeButton.getAttribute('data-post-id');
            const liked = likeButton.getAttribute('data-liked') === 'true';

            fetch('/likes', {
                method: liked ? 'DELETE' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ post_id: postId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update liked status
                    const newLiked = !liked;
                    likeButton.setAttribute('data-liked', newLiked ? 'true' : 'false');

                    // Toggle button color
                    likeButton.classList.toggle('btn-danger', newLiked);
                    likeButton.classList.toggle('btn-primary', !newLiked);

                    // Update icon and text
                    likeIcon.className = newLiked ? 'bi bi-hand-thumbs-down-fill' : 'bi bi-hand-thumbs-up-fill';
                    likeText.textContent = newLiked ? 'Dislike' : 'Like';

                    // Update like count
                    likeCount.textContent = `${data.likes_count} ${data.likes_count === 1 ? 'like' : 'likes'}`;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});
