function liveSearch() {
    const docket = document.getElementById('search-input').value;
    const status = document.getElementById('hearing-status-filter').value;

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('SearchByDcn', docket);
    formData.append('Hearing_status', status);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("records-body").innerHTML = xhr.responseText;
        }
    };

    xhr.open("POST", "../backend/filter.records.controller.php", true);
    xhr.send(formData);
}

function showGalleryImages(docketNumber) {
    const xhr = new XMLHttpRequest();
    // Changed to GET request and appended docket as a query parameter
    xhr.open("GET", `../backend/get.gallery.php?docket=${encodeURIComponent(docketNumber)}`, true);
    xhr.setRequestHeader('Accept', 'application/json'); // Request JSON response

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // Request finished and response is ready
            const modal = document.getElementById('gallery-modal');
            const galleryContainer = modal.querySelector('.gallery-images');

            if (xhr.status === 200) {
                try {
                    const images = JSON.parse(xhr.responseText);

                    if (Array.isArray(images) && images.length > 0) {
                        // Map each base64 string to an <img> tag
                        galleryContainer.innerHTML = images.map(base64 => `
                            <img src="data:image/jpeg;base64,${base64}" class="gallery-image" alt="Uploaded Image" />
                        `).join('');
                    } else {
                        galleryContainer.innerHTML = '<p class="text-gray-600">No images uploaded for this case yet.</p>';
                    }

                    modal.classList.add('active'); // Show modal by adding 'active' class
                    document.body.style.overflow = 'hidden'; // Prevent scrolling body when modal is open

                } catch (e) {
                    // Handle JSON parsing errors
                    galleryContainer.innerHTML = '<p class="text-red-600">Error loading images: Invalid data received.</p>';
                    console.error("Invalid JSON from backend:", xhr.responseText, e);
                }
            } else {
                // Handle HTTP errors (e.g., 404, 500)
                galleryContainer.innerHTML = `<p class="text-red-600">Failed to load images. Server responded with status: ${xhr.status}</p>`;
                console.error("Server error:", xhr.status, xhr.responseText);
            }
        }
    };

    xhr.send(); // No formData for GET request
}

function closeGalleryModal() {
    const modal = document.getElementById('gallery-modal');
    if (modal) {
        modal.classList.remove('active'); // Hide modal by removing 'active' class
        document.body.style.overflow = ''; // Restore body scrolling
        // Clear images when closing to prevent old images showing on next open
        const galleryContainer = modal.querySelector('.gallery-images');
        if (galleryContainer) {
            galleryContainer.innerHTML = '';
        }
    }
}