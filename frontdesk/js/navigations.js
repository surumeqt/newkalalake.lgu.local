document.addEventListener("DOMContentLoaded", () => {
    loadDashboardStats();
    const navLinks = document.querySelectorAll(
        'nav a[data-load-content="true"]'
    );
    const contentDisplay = document.querySelector(".content-display");
    const pageTitleElement = document.querySelector(".current-page-title");
    const menuToggleBtn = document.querySelector(".menu-toggle");
    const sidebar = document.querySelector(".sidebar");
    const sidebarOverlay = document.querySelector(".sidebar-overlay");

    // Key for storing the last visited page in localStorage
    const LAST_PAGE_KEY = "lastLoadedPageUrl";

    const setActiveLink = (currentLink) => {
        navLinks.forEach((link) => link.classList.remove("active"));
        if (currentLink) currentLink.classList.add("active");
    };

    const updatePageTitle = (title) => {
        if (pageTitleElement) pageTitleElement.textContent = title;
    };

    const loadContent = (url, linkElement = null) => {
        contentDisplay.innerHTML = '<p class="loading-message">Loading...</p>';
        loadDashboardStats();
        fetch(url)
            .then((response) => {
                if (!response.ok)
                    throw new Error(`HTTP error! Status: ${response.status}`);
                return response.text();
            })
            .then((html) => {
                contentDisplay.innerHTML = html;

                // Determine the page name from the URL to call specific functions
                const urlParts = url.split("/");
                const pageFileName = urlParts[urlParts.length - 1]; // e.g., "fd_residents.php"

                // IMPORTANT: Ensure these functions are globally available (e.g., in functions.js loaded before this script)
                if (
                    pageFileName === "fd_residents.php" &&
                    typeof toggleBusinessFields === "function"
                ) {
                    toggleBusinessFields();
                }
                if (
                    pageFileName === "fd_certificate.php" &&
                    typeof handleCertificateChange === "function"
                ) {
                    // Assuming you have a default select element for certificates, pass it here
                    const certificateSelect = document.querySelector(
                        'select[onchange="handleCertificateChange(this)"]'
                    );
                    if (certificateSelect) {
                        handleCertificateChange(certificateSelect);
                    }
                }
                // Add more conditions here for other page-specific initializations if needed

                if (linkElement) {
                    setActiveLink(linkElement);
                    updatePageTitle(linkElement.textContent.trim());
                    // Store the URL of the clicked link in localStorage
                    localStorage.setItem(LAST_PAGE_KEY, url);
                } else {
                    // This block runs for the initial page load (from localStorage or default)
                    // Find the link element that matches the loaded URL
                    const loadedLink = Array.from(navLinks).find(
                        (link) => link.href === url
                    );
                    if (loadedLink) {
                        setActiveLink(loadedLink);
                        updatePageTitle(loadedLink.textContent.trim());
                    } else {
                        // Fallback if somehow the stored URL doesn't match a nav link
                        const firstNavLink = navLinks[0];
                        if (firstNavLink) {
                            setActiveLink(firstNavLink);
                            updatePageTitle(firstNavLink.textContent.trim());
                            localStorage.setItem(
                                LAST_PAGE_KEY,
                                firstNavLink.href
                            ); // Store default
                        }
                    }
                }
            })
            .catch((error) => {
                console.error("Error loading content:", error);
                contentDisplay.innerHTML = `<p class="error-message">Failed to load: ${error.message}</p>`;
                // Clear localStorage if content failed to load to prevent perpetual errors
                localStorage.removeItem(LAST_PAGE_KEY);
            });
    };

    // --- Handle Navigation Link Clicks ---
    navLinks.forEach((link) => {
        link.addEventListener("click", (event) => {
            event.preventDefault();
            loadContent(event.target.href, event.target);

            // Close the sidebar when a nav link is clicked on smaller screens
            if (
                window.innerWidth <= 768 &&
                sidebar &&
                sidebar.classList.contains("active")
            ) {
                sidebar.classList.remove("active");
                if (sidebarOverlay) {
                    sidebarOverlay.style.display = "none";
                }
            }
        });
    });

    // --- Initial Load Logic ---
    const storedPageUrl = localStorage.getItem(LAST_PAGE_KEY);

    if (storedPageUrl) {
        // Load the stored page if available
        loadContent(storedPageUrl);
    } else if (navLinks.length > 0) {
        // Otherwise, load the dashboard content by default on page load
        loadContent(navLinks[0].href, navLinks[0]);
    }

    // --- Sidebar Toggle Logic (existing) ---
    if (menuToggleBtn && sidebar) {
        menuToggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("active");
            if (sidebarOverlay) {
                sidebarOverlay.style.display = sidebar.classList.contains(
                    "active"
                )
                    ? "block"
                    : "none";
            }
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener("click", () => {
            sidebar.classList.remove("active");
            sidebarOverlay.style.display = "none";
        });
    }

    window.addEventListener("resize", () => {
        if (window.innerWidth > 768 && sidebar.classList.contains("active")) {
            sidebar.classList.remove("active");
            if (sidebarOverlay) {
                sidebarOverlay.style.display = "none";
            }
        }
    });
});
