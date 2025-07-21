// frontdesk\js\functions.js

function reflectAge() {
    // CORRECTED: Changed "birthday" to "birthDate" to match the HTML ID
    const birthdayInput = document.getElementById("birthDate");

    if (birthdayInput && birthdayInput.value) {
        // Check if input exists and has a value
        const birthDate = new Date(birthdayInput.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (
            monthDiff < 0 ||
            (monthDiff === 0 && today.getDate() < birthDate.getDate())
        ) {
            age--;
        }
        document.getElementById("age").value = age;
    } else {
        // If no birthday is selected, clear the age field
        const ageInput = document.getElementById("age");
        if (ageInput) {
            ageInput.value = "";
        }
    }
}
// Ensure this function is present in your functions.js or modal.logic.js
// It's specific for the edit modal's input IDs
function reflectAgeForEditModal() {
    const birthdayInput = document.getElementById("edit_birthDate");
    const ageInput = document.getElementById("edit_age");

    if (birthdayInput && birthdayInput.value) {
        const birthDate = new Date(birthdayInput.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (
            monthDiff < 0 ||
            (monthDiff === 0 && today.getDate() < birthDate.getDate())
        ) {
            age--;
        }
        if (ageInput) {
            // Ensure ageInput exists before setting value
            ageInput.value = age;
        }
    } else {
        if (ageInput) {
            // Ensure ageInput exists before clearing
            ageInput.value = "";
        }
    }
}
function liveSearch(page = 1) {
    const searchInput = document.getElementById("residentSearchInput").value;
    const residentsBody = document.getElementById("residents-body");
    const paginationContainer = document.querySelector(".table-pagination");

    // Clear previous content and show a loading indicator
    if (residentsBody) {
        residentsBody.innerHTML =
            '<tr><td colspan="8" style="text-align: center; padding: 20px;">Loading...</td></tr>';
    }
    if (paginationContainer) {
        paginationContainer.innerHTML = ""; // Clear pagination while loading
    }

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append("action", "search_residents");
    formData.append("residentSearchInput", searchInput);
    formData.append("page", page);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            // Request is complete
            if (xhr.status === 200) {
                // HTTP status is OK
                try {
                    const response = JSON.parse(xhr.responseText);
                    console.log("Live Search Response:", response); // Debugging: log the full response

                    if (response.tableRows) {
                        residentsBody.innerHTML = response.tableRows;
                    } else {
                        residentsBody.innerHTML =
                            '<tr><td colspan="8" style="text-align: center; padding: 20px;">No resident match found.</td></tr>';
                    }

                    if (response.paginationLinks) {
                        paginationContainer.innerHTML =
                            response.paginationLinks;
                        attachPaginationListeners(); // Re-attach listeners after content update
                    } else {
                        paginationContainer.innerHTML = ""; // Clear pagination if no links
                    }
                } catch (e) {
                    console.error(
                        "Error parsing JSON response or updating content:",
                        e
                    );
                    console.error("Response Text:", xhr.responseText);
                    residentsBody.innerHTML =
                        '<tr><td colspan="8" style="text-align: center; padding: 20px; color: red;">Error loading residents. Please try again.</td></tr>';
                }
            } else {
                console.error("HTTP Error:", xhr.status, xhr.statusText);
                console.error("Response Text:", xhr.responseText);
                residentsBody.innerHTML = `<tr><td colspan="8" style="text-align: center; padding: 20px; color: red;">Server error: ${xhr.status} ${xhr.statusText}.</td></tr>`;
            }
        }
    };

    xhr.open(
        "POST",
        "../backend/fd_controllers/residents.controller.php",
        true
    );
    xhr.send(formData);
}

function attachPaginationListeners() {
    const paginationContainer = document.querySelector(".table-pagination");

    if (paginationContainer) {
        // Remove ALL existing click listeners on the container to prevent duplicates
        // This is a more robust way to ensure only one listener is active.
        const newPaginationContainer = paginationContainer.cloneNode(true);
        paginationContainer.parentNode.replaceChild(
            newPaginationContainer,
            paginationContainer
        );

        newPaginationContainer.addEventListener("click", handlePaginationClick);
    } else {
        console.warn(
            "Pagination container (.table-pagination) not found. Cannot attach listeners."
        );
    }
}

function handlePaginationClick(event) {
    const target = event.target;
    // REVERTED: Check for 'page-link' class again
    if (
        target.classList.contains("page-link") && // <--- Changed class name back to page-link
        target.hasAttribute("data-page")
    ) {
        event.preventDefault(); // Prevent default link behavior
        const page = target.getAttribute("data-page");
        liveSearch(page);
    }
}
// Initial call to load residents and attach pagination listeners when the page loads
document.addEventListener("DOMContentLoaded", () => {
    liveSearch(); // Load initial data
});

function initializePhotoUpload() {
    const photoInput = document.getElementById("photo");
    const uploadButton = document.querySelector(".upload-button");
    const fileNameSpan = document.querySelector(".file-name");
    const photoPreviewContainer = document.querySelector(".photo-preview");
    const previewImage = document.querySelector(".preview-image");

    if (
        photoInput &&
        uploadButton &&
        fileNameSpan &&
        photoPreviewContainer &&
        previewImage
    ) {
        // When the custom button is clicked, trigger the hidden file input click
        uploadButton.addEventListener("click", () => {
            photoInput.click();
        });

        // When a file is selected in the input
        photoInput.addEventListener("change", function () {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();

                // Display file name
                fileNameSpan.textContent = file.name;
                fileNameSpan.style.display = "inline-block"; // Show the file name

                // Read file for preview
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    photoPreviewContainer.style.display = "block"; // Show the preview container
                };
                reader.readAsDataURL(file);
            } else {
                // No file selected
                fileNameSpan.textContent = "No file chosen";
                fileNameSpan.style.display = "none"; // Hide if no file
                photoPreviewContainer.style.display = "none"; // Hide preview
                previewImage.src = ""; // Clear preview image
            }
        });

        // Optional: Clear photo and preview when modal is closed or form reset
        const addResidentForm = document.getElementById("addResidentForm");
        addResidentForm.addEventListener("reset", () => {
            fileNameSpan.textContent = "No file chosen";
            fileNameSpan.style.display = "none";
            photoPreviewContainer.style.display = "none";
            previewImage.src = "";
        });
    } else {
        console.warn(
            "Could not find all elements for photo upload initialization. Check IDs and classes."
        );
    }
}
