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

function liveSearch(page = 1) {
    const searchInput = document.getElementById("residentSearchInput").value;

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append("residentSearchInput", searchInput);
    formData.append("page", page);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                document.getElementById("residents-body").innerHTML =
                    response.tableRows;
                document.querySelector(".table-pagination").innerHTML =
                    response.paginationLinks;
                attachPaginationListeners(); // Re-attach listeners after content update
            } catch (e) {
                console.error(
                    "Error parsing JSON response or updating content:",
                    e
                );
                console.error("Response Text:", xhr.responseText);
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

    // ADD THIS CHECK: Ensure paginationContainer exists before trying to add/remove listeners
    if (paginationContainer) {
        // Remove existing listeners to prevent duplicates before adding a new one
        paginationContainer.removeEventListener("click", handlePaginationClick);
        paginationContainer.addEventListener("click", handlePaginationClick);
    } else {
        // Optional: Log a warning if the element isn't found, helpful for debugging
        console.warn(
            "Pagination container (.table-pagination) not found. Cannot attach listeners."
        );
    }
}

function handlePaginationClick(event) {
    const target = event.target;
    if (
        target.classList.contains("page-link") &&
        target.hasAttribute("data-page")
    ) {
        event.preventDefault();
        const page = target.getAttribute("data-page");
        liveSearch(page);
    }
}

// REMEMBER to ensure this specific document.addEventListener('DOMContentLoaded', ...)
// block (if it existed) is removed from this file, as per the previous instruction,
// because the call to attachPaginationListeners() should now be handled
// by fd_app.php's loadContent function directly.
