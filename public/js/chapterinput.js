document.addEventListener('DOMContentLoaded', function() {
    const maxContentLength = 9000;

    const postsDataElement = document.getElementById('postsData');
    if (!postsDataElement) {
        console.error('postsData element not found.');
        return;
    }

    const posts = JSON.parse(postsDataElement.textContent);

    posts.forEach(post => {
        const quillEditor = new Quill(`#quill-editor-${post.id}`, {
            theme: 'snow',
            placeholder: 'Write your chapter content here...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['clean']
                ]
            }
        });

        quillEditor.on('text-change', function(delta, oldDelta, source) {
            const contentLength = quillEditor.getText().trim().length;
            const warningElement = document.querySelector(`#content-warning-${post.id}`);
            const counterElement = document.querySelector(`#content-counter-${post.id}`);

            counterElement.textContent = `${contentLength}/${maxContentLength}`;

            if (contentLength > maxContentLength) {
                quillEditor.deleteText(maxContentLength, contentLength);
                warningElement.textContent = `Content is limited to ${maxContentLength} characters.`;
            } else {
                warningElement.textContent = '';
            }
        });

        const form = document.querySelector(`#addChapterModal${post.id} form`);
        form.addEventListener('submit', function() {
            const contentInput = document.querySelector(`#content-${post.id}`);
            const quillContent = quillEditor.root.innerHTML;

            // Sanitize the Quill content using DOMPurify
            const sanitizedContent = DOMPurify.sanitize(quillContent);
            contentInput.value = sanitizedContent;
        });
    });
});