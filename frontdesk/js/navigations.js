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
                if (linkElement) {
                    setActiveLink(linkElement);
                    updatePageTitle(linkElement.textContent.trim());
                } else {
                    const firstNavLink = navLinks[0];
                    if (firstNavLink) {
                        setActiveLink(firstNavLink);
                        updatePageTitle(firstNavLink.textContent.trim());
                    }
                }
            })
            .catch((error) => {
                console.error("Error loading content:", error);
                contentDisplay.innerHTML = `<p class="error-message">Failed to load: ${error.message}</p>`;
            });
    };

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
                    sidebarOverlay.style.display = "none"; // Hide overlay
                }
            }
        });
    });

    if (navLinks.length > 0) {
        // Load the dashboard content by default on page load
        loadContent(navLinks[0].href, navLinks[0]);
    }

    if (menuToggleBtn && sidebar) {
        menuToggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("active");
            if (sidebarOverlay) {
                // Toggle overlay display based on sidebar active state
                sidebarOverlay.style.display = sidebar.classList.contains(
                    "active"
                )
                    ? "block"
                    : "none";
            }
        });
    }

    // Close sidebar when overlay is clicked
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener("click", () => {
            sidebar.classList.remove("active");
            sidebarOverlay.style.display = "none";
        });
    }

    // Optional: Close sidebar if window is resized to a larger size while menu is open
    window.addEventListener("resize", () => {
        if (window.innerWidth > 768 && sidebar.classList.contains("active")) {
            sidebar.classList.remove("active");
            if (sidebarOverlay) {
                sidebarOverlay.style.display = "none";
            }
        }
    });
});
