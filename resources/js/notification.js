document.addEventListener('DOMContentLoaded', function () {
    const notificationDropdownBtn = document.getElementById('notificationDropdownBtn');
    const notificationBadge = document.getElementById('notificationBadge');

    if (notificationDropdownBtn) {
        notificationDropdownBtn.addEventListener('show.bs.dropdown', function () {
            if (notificationBadge) {
                // Hide the badge immediately
                notificationBadge.style.display = 'none';

                // Send request to mark notifications as read
                fetch('/notifications/mark-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({})
                }).then(response => {
                    if (!response.ok) {
                        // If error, show the badge again
                        notificationBadge.style.display = 'inline-block';
                    }
                }).catch(() => {
                    // On error, show the badge again
                    notificationBadge.style.display = 'inline-block';
                });
            }
        });
    }
});
