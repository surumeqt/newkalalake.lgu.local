document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status");

    const toast = document.getElementById("notification-toast");
    const toastContent = document.getElementById("toast-content");
    const toastIcon = document.getElementById("toast-icon-img");
    const toastMessage = document.getElementById("toast-message"); // Define messages and icons per status

    const toastData = {
        success: {
            message: "Resident added successfully!",
            icon: "images/icons/checkmark-48.png",
            type: "success",
        },
        error: {
            message: "Error submitting case. Please try again.",
            icon: "images/icons/cross-48.png",
            type: "error",
        },
        updated: {
            message: "Resident updated successfully!",
            icon: "images/icons/checkmark-48.png",
            type: "success",
        },
        update_failed: {
            message: "Failed to update resident. Please try again.",
            icon: "images/icons/cross-48.png",
            type: "error",
        },
    };

    if (toastData[status]) {
        // Apply content
        toastMessage.textContent = toastData[status].message;
        toastIcon.src = toastData[status].icon; // Reset class then apply type-specific class

        toastContent.className = "toast-content " + toastData[status].type;

        toast.classList.add("show"); // Auto-hide

        setTimeout(() => {
            toast.classList.remove("show");
        }, 5000);
    } // Clean up URL

    if (window.history.replaceState) {
        const cleanUrl = window.location.origin + window.location.pathname;
        window.history.replaceState(null, null, cleanUrl);
    }
});
