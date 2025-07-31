document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status");

    const toast = document.getElementById("notification-toast");
    const toastIcon = document.getElementById("toast-icon-img");
    const toastMessage = document.getElementById("toast-message");

    if (!toast) return;

    if (status) {
        let message = "";
        let icon = "";
        let backgroundColor = "";

        switch (status) {
            case "success":
                message = "Resident added successfully!";
                icon = "images/icons/checkmark-48.png";
                break;
            case "updated":
                message = "Resident updated successfully!";
                icon = "images/icons/checkmark-48.png";
                break;
            case "update_failed":
                message = "Failed to update resident.";
                icon = "images/icons/cross-48.png";
                break;
            case "certificate_success":
                message = "Certificate issued successfully!";
                icon = "images/icons/checkmark-48.png";
                break;
            case "certificate_failed":
                message = "Failed to issue certificate.";
                icon = "images/icons/cross-48.png";
                break;
            default:
                return;
        }

        toastMessage.textContent = message;
        toastIcon.src = icon;
        toast.style.backgroundColor = backgroundColor;
        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
        }, 4000); // Clean the URL

        if (window.history.replaceState) {
            const cleanUrl = window.location.origin + window.location.pathname;
            window.history.replaceState(null, null, cleanUrl);
        }
    }
});
