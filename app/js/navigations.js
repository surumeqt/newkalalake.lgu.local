document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll(
        'nav a[data-load-content="true"], div a[data-load-content="true"], div button[data-load-content="true"]'
    );
    const contentDisplay = document.querySelector(".content-display");
    const pageTitleElement = document.querySelector(".current-page-title");
    const menuToggleBtn = document.querySelector(".menu-toggle");
    const sidebar = document.querySelector(".sidebar");
    // Add reference to the sidebar overlay
    const sidebarOverlay = document.getElementById("sidebarOverlay");

    const setActiveLink = (currentLink) => {
        navLinks.forEach((link) => link.classList.remove("active"));
        if (currentLink) currentLink.classList.add("active");
    };

    const updatePageTitle = (title) => {
        if (pageTitleElement) pageTitleElement.textContent = title;
    };

    const loadContent = (url, linkElement = null) => {
        contentDisplay.innerHTML = '<p class="loading-message">Loading...</p>';

        fetch(url)
            .then((response) => {
                if (!response.ok)
                    throw new Error(`HTTP error! Status: ${response.status}`);
                return response.text();
            })
            .then((html) => {
                contentDisplay.innerHTML = html;

                // *** CALL YOUR MODAL INITIALIZATION FUNCTION HERE ***
                if (typeof initializeAddResidentModal === "function") {
                    initializeAddResidentModal();
                }

                // NEW: Call the initialization function for the Select Certificate Type Modal
                if (typeof initializeSelectCertificateTypeModal === "function") {
                    initializeSelectCertificateTypeModal();
                }
                // You might need to call other initialization functions here
                // if other dynamically loaded content also requires JS setup.

                if (linkElement) {
                    // For buttons, linkElement is the button itself.
                    // We need to find the *corresponding navigation link*
                    // in the sidebar to set it active.
                    let navLinkToActivate = null;
                    if (linkElement.tagName === "A") {
                        // If it's a regular navigation link
                        navLinkToActivate = linkElement;
                    } else if (linkElement.tagName === "BUTTON") {
                        // If it's a button from quick actions
                        const buttonUrl = linkElement.getAttribute("data-url");
                        // Find the sidebar link whose href matches the button's data-url
                        navLinkToActivate = document.querySelector(
                            `.main-nav a[href='${buttonUrl}']`
                        );
                    }

                    if (navLinkToActivate) {
                        setActiveLink(navLinkToActivate);
                        updatePageTitle(navLinkToActivate.textContent.trim());
                    }
                } else {
                    // Fallback for initial load or if linkElement isn't provided
                    const currentPath = window.location.pathname
                        .split("/")
                        .pop();
                    const activeLink = document.querySelector(
                        `.main-nav a[href*="${currentPath}"]`
                    );
                    if (activeLink) {
                        setActiveLink(activeLink);
                        updatePageTitle(activeLink.textContent.trim());
                    } else if (navLinks.length > 0) {
                        // Default to first link if no match
                        setActiveLink(navLinks[0]);
                        updatePageTitle(navLinks[0].textContent.trim());
                    }
                }
            })
            .catch((error) => {
                console.error("Error loading content:", error);
                contentDisplay.innerHTML = `<p class="error-message">Failed to load: ${error.message}</p>`;
            });
    };

    //     navLinks.forEach(link => {
    //         link.addEventListener('click', (event) => {
    //             event.preventDefault();
    //             loadContent(event.target.href, event.target);

    //             if (window.innerWidth <= 600 && sidebar && sidebar.classList.contains('active')) {
    //                 sidebar.classList.remove('active');
    //             }
    //         });
    //     });
    // NEW AND IMPROVED BLOCK - REPLACE THE OLD navLinks.forEach LOOP WITH THIS
    document.addEventListener("click", (event) => {
        const clickableElement = event.target.closest(
            '[data-load-content="true"]'
        ); // Catches both <a> and <button>

        if (clickableElement) {
            event.preventDefault(); // Prevent default link/button action

            const url =
                clickableElement.getAttribute("href") || // For <a> tags
                clickableElement.getAttribute("data-url"); // For <button> tags

            if (url) {
                loadContent(url, clickableElement);
            } else {
                console.warn(
                    'Clicked element has data-load-content="true" but no href or data-url attribute:',
                    clickableElement
                );
            }

            // --- UPDATED SIDEBAR CLOSING LOGIC ---
            // Add sidebar closing logic here, ensuring the overlay is also removed
            if (
                window.innerWidth <= 600 &&
                sidebar &&
                sidebar.classList.contains("active")
            ) {
                sidebar.classList.remove("active");

                // Ensure sidebarOverlay is defined (we added this check in a previous step)
                // and remove its 'active' class to dismiss the overlay
                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove("active");
                }
            }
            // --- END OF UPDATED LOGIC ---
        }
    });

    if (navLinks.length > 0) {
        loadContent(navLinks[0].href, navLinks[0]);
    }

    if (menuToggleBtn && sidebar) {
        menuToggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("active");

            // Also toggle the 'active' class on the sidebar-overlay to show/hide the dimming effect
            if (sidebarOverlay) {
                sidebarOverlay.classList.toggle(
                    "active",
                    sidebar.classList.contains("active")
                );
            }
        });
    }
    // New logic to close sidebar when clicking the overlay (click-outside functionality)
    if (sidebarOverlay && sidebar) {
        sidebarOverlay.addEventListener("click", (event) => {
            // Check if the click target is the overlay itself, not a child element inside the sidebar.
            // If the user clicks on the overlay, close the sidebar.
            if (event.target === sidebarOverlay) {
                sidebar.classList.remove("active");
                sidebarOverlay.classList.remove("active");
            }
        });
    }
});