document.addEventListener('DOMContentLoaded', function() {
    // Handle Read More clicks
    document.querySelectorAll('.read-more-toggle').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const container = this.closest('.post-description');
            container.querySelector('.collapsed-description').classList.add('d-none');
            container.querySelector('.full-description').classList.remove('d-none');
        });
    });

    // Handle Read Less clicks
    document.querySelectorAll('.read-less-toggle').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const container = this.closest('.post-description');
            container.querySelector('.full-description').classList.add('d-none');
            container.querySelector('.collapsed-description').classList.remove('d-none');

            // Smooth scroll back to description
            container.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        });
    });
});
