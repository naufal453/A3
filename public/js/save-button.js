// Save Button Functionality
(function() {
    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', initSaveButton);

    function initSaveButton() {
        // Use event delegation for dynamic elements
        document.addEventListener('click', handleSaveClick);
    }

    function handleSaveClick(event) {
        const saveBtn = event.target.closest('.save-action');
        if (!saveBtn) return;

        event.preventDefault();
        event.stopPropagation();

        // Get button data
        const postId = saveBtn.dataset.postId;
        const isSaved = saveBtn.dataset.saved === 'true';
        const action = isSaved ? 'unsave' : 'save';
        
        // Show loading state
        setButtonState(saveBtn, 'loading');

        // Make API request
        fetch(`/posts/${postId}/${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(handleResponse)
        .then(data => updateButton(saveBtn, data, !isSaved))
        .catch(handleError)
        .finally(() => saveBtn.disabled = false);
    }

    function setButtonState(button, state) {
        button.disabled = true;
        if (state === 'loading') {
            button.innerHTML = `<i class="bi bi-arrow-repeat"></i>`;
        }
    }

    function handleResponse(response) {
        if (!response.ok) throw new Error('Network error');
        return response.json();
    }

    function updateButton(button, data, newSavedState) {
        if (data.success) {
            button.dataset.saved = newSavedState.toString();
            button.innerHTML = `
                <i class="bi ${newSavedState ? 'bi-bookmark-check-fill' : 'bi-bookmark'}"></i>
                <span class="d-none d-sm-inline">${newSavedState ? 'Saved' : 'Save'}</span>
            `;
        }
    }

    function handleError(error) {
        console.error('Save error:', error);
        alert('Failed to update save status. Please try again.');
    }
})();
