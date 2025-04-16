// Scroll to Top Button Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Create the button
    const scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.innerHTML = '<i class="bi bi-arrow-up"></i> Top';
    scrollToTopBtn.id = 'scrollToTopBtn';
    scrollToTopBtn.style.display = 'none'; // Initially hidden
    scrollToTopBtn.style.position = 'fixed';
    scrollToTopBtn.style.bottom = '20px';
    scrollToTopBtn.style.right = '20px';
    scrollToTopBtn.style.zIndex = '1000';
    scrollToTopBtn.style.backgroundColor = '#007bff';
    scrollToTopBtn.style.color = '#fff';
    scrollToTopBtn.style.border = 'none';
    scrollToTopBtn.style.borderRadius = '5px';
    scrollToTopBtn.style.padding = '10px';
    scrollToTopBtn.style.cursor = 'pointer';
    document.body.appendChild(scrollToTopBtn);

    // Show button after scrolling down 300px
    window.onscroll = function() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            scrollToTopBtn.style.display = 'block';
        } else {
            scrollToTopBtn.style.display = 'none';
        }
    };

    // Smooth scroll to top on button click
    scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
