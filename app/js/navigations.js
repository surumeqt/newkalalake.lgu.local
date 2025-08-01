// A globally accessible function to load content via AJAX.
window.loadContent = (url) => {
    const contentDisplay = document.querySelector(".content-display");
    const pageTitleElement = document.querySelector(".current-page-title");
    const navLinks = document.querySelectorAll(
        'nav a[data-load-content="true"]'
    );
    const STORAGE_KEY = "currentPageUrl";

    if (!contentDisplay) {
        console.error("Content display element not found.");
        return;
    }

    contentDisplay.innerHTML = '<p class="loading-message">Loading...</p>';

    fetch(url)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
        })
        .then((html) => {
            contentDisplay.innerHTML = html;

            // <--- IMPORTANT FIX HERE --->
            // Find the corresponding link in the main navigation based on the URL
            const correspondingNavLink = Array.from(navLinks).find((link) =>
                link.href.includes(url.split("?")[0])
            );

            // Set the active state and title based on the corresponding nav link
            navLinks.forEach((link) => link.classList.remove("active"));
            if (correspondingNavLink) {
                correspondingNavLink.classList.add("active");
                if (pageTitleElement) {
                    pageTitleElement.textContent =
                        correspondingNavLink.textContent.trim();
                }

                // Save the URL to local storage to persist on refresh
                localStorage.setItem(STORAGE_KEY, url);
                console.log(`Saved URL to localStorage: ${url}`);
            } else {
                console.warn(
                    `No corresponding link found in the main navigation for URL: "${url}".`
                );
            }

            // After loading new content, re-initialize event listeners for links within that content.
            initializeContentLinks();
        })
        .catch((error) => {
            console.error("Error loading content:", error);
            contentDisplay.innerHTML = `<p class="error-message">Failed to load: ${error.message}</p>`;
        });
};

// New function to attach listeners to dynamic content.
const initializeContentLinks = () => {
    // Select all links inside the content-display that should load new content
    const contentLinks = document.querySelectorAll(
        '.content-display a[data-load-content="true"]'
    );
    contentLinks.forEach((link) => {
        // Only attach if it doesn't have an event listener already
        if (!link.getAttribute("data-listener-attached")) {
            link.addEventListener("click", (event) => {
                event.preventDefault();
                const url = event.currentTarget.href;
                window.loadContent(url);
            });
            link.setAttribute("data-listener-attached", "true"); // Mark as attached
        }
    });
};

document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll(
        'nav a[data-load-content="true"]'
    );
    const sidebar = document.querySelector(".sidebar");
    const menuToggleBtn = document.querySelector(".menu-toggle");
    const STORAGE_KEY = "currentPageUrl";

    // Attach listeners for sidebar links on initial load
    navLinks.forEach((link) => {
        link.addEventListener("click", (event) => {
            event.preventDefault();
            const url = event.currentTarget.href;
            window.loadContent(url);
            if (
                window.innerWidth <= 600 &&
                sidebar &&
                sidebar.classList.contains("active")
            ) {
                sidebar.classList.remove("active");
            }
        });
    });

    // Handle the initial page load based on localStorage
    const storedUrl = localStorage.getItem(STORAGE_KEY);
    const defaultUrl = navLinks.length > 0 ? navLinks[0].href : null;

    if (storedUrl) {
        console.log(`Loading content from localStorage: ${storedUrl}`);
        window.loadContent(storedUrl);
    } else if (defaultUrl) {
        console.log(
            `No URL in localStorage. Loading default page: ${defaultUrl}`
        );
        window.loadContent(defaultUrl);
    } else {
        console.error("No navigation links found. Cannot load any content.");
    }

    // Handle menu toggle button for responsive design
    if (menuToggleBtn && sidebar) {
        menuToggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("active");
        });
    }

    // Clean up URL on initial load if status parameter exists
    const url = new URL(window.location.href);
    if (url.searchParams.has("status")) {
        url.searchParams.delete("status");
        window.history.replaceState({}, document.title, url.toString());
    }
});
