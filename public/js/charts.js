document.addEventListener('DOMContentLoaded', function() {
    const posts = JSON.parse(document.getElementById('postsData').textContent);

    if (posts.length === 0) {
        console.warn('No posts data available for charts.');
        return;
    }

    // Sort posts by likes in descending order and take the top 3
    const topPosts = posts.sort((a, b) => b.likes - a.likes).slice(0, 3);

    // Left Chart: Individual Post Stats (Top 3)
    const ctxLeft = document.getElementById('userStatsChart').getContext('2d');

    const postTitles = topPosts.map(post => post.title);
    const likeCounts = topPosts.map(post => post.likes);

    new Chart(ctxLeft, {
        type: 'polarArea', // Polar Area Chart
        data: {
            labels: postTitles,
            datasets: [
                {
                    label: 'Likes',
                    data: likeCounts,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    // Right Chart: Total Likes and Comments
    const ctxRight = document.getElementById('totalStatsChart').getContext('2d');
    const totalLikes = posts.reduce((sum, post) => sum + post.likes, 0);
    const totalComments = posts.reduce((sum, post) => sum + post.comments, 0);

    new Chart(ctxRight, {
        type: 'doughnut',
        data: {
            labels: ['Total Likes', 'Total Comments'],
            datasets: [{
                data: [totalLikes, totalComments],
                backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
});