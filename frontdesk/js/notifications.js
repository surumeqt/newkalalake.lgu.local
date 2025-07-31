document.addEventListener("DOMContentLoaded", () => {
    const notificationToast = document.getElementById("notification-toast");

    if (notificationToast) {
        // Check if there's any content to display (from PHP session)
        const messageSpan = notificationToast.querySelector(
            ".success-message, .error-message"
        );

        if (messageSpan && messageSpan.textContent.trim() !== "") {
            // Show the toast
            notificationToast.classList.add("show");

            // Automatically hide after 5 seconds
            setTimeout(() => {
                notificationToast.classList.remove("show");
                // Optional: Remove content after hiding for cleanliness
                setTimeout(() => {
                    notificationToast.innerHTML = "";
                }, 500); // Match CSS transition duration
            }, 5000); // 5000 milliseconds = 5 seconds
        }
    }
});
