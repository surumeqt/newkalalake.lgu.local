document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll(
        'nav a[data-load-content="true"], div a[data-load-content="true"], div button[data-load-content="true"]'
    );
    const contentDisplay = document.querySelector(".content-display");
    const pageTitleElement = document.querySelector(".current-page-title");
    const menuToggleBtn = document.querySelector(".menu-toggle");
    const sidebar = document.querySelector(".sidebar");
    const sidebarOverlay = document.getElementById("sidebarOverlay");

    // Get specific elements for the resident profile link
    const residentProfileLi = document.querySelector(".fdresidentprofile_li");
    const residentProfileA = document.querySelector(".fdresidentprofile_a");

    const setActiveLink = (currentLinkElement, loadedUrl = null) => {
        // 1. Clear active classes from all main navigation links
        navLinks.forEach((link) => link.classList.remove("active"));

        // 2. Hide the resident profile link by default for any new navigation
        if (residentProfileLi) {
            residentProfileLi.style.display = "none";
            residentProfileA.classList.remove("active"); // Ensure its link is not active
        }

        // Determine the effective URL for activation logic
        let urlToActivate = loadedUrl;
        if (currentLinkElement) {
            urlToActivate =
                currentLinkElement.getAttribute("href") ||
                currentLinkElement.getAttribute("data-url");
        }
        // Clean URL to match against navigation links (remove query parameters)
        const cleanUrlToActivate = urlToActivate
            ? urlToActivate.split("?")[0]
            : null;

        // 3. Apply 'active' class and manage visibility based on the target URL
        if (cleanUrlToActivate) {
            if (cleanUrlToActivate.includes("fd_resident_profile.php")) {
                // If the resident profile page is being loaded/activated
                if (residentProfileLi) {
                    residentProfileLi.style.display = "list-item"; // Make visible
                    residentProfileA.classList.add("active"); // Make active
                }
                updatePageTitle("Resident Profile"); // Set title explicitly for profile page
            } else {
                // For other main navigation links (Dashboard, Residents, Certificate)
                // Find the corresponding <a> tag in the main navigation
                const correspondingNavLink = document.querySelector(
                    `.main-nav a[href*="${cleanUrlToActivate}"]`
                );
                if (correspondingNavLink) {
                    correspondingNavLink.classList.add("active");
                    updatePageTitle(correspondingNavLink.textContent.trim());
                } else if (
                    currentLinkElement &&
                    currentLinkElement.tagName === "A"
                ) {
                    // Fallback for directly clicked main nav links
                    currentLinkElement.classList.add("active");
                    updatePageTitle(currentLinkElement.textContent.trim());
                }
            }
        }
    };

    const updatePageTitle = (title) => {
        if (pageTitleElement) pageTitleElement.textContent = title;
    };

    // MODIFIED: loadContent to store the last loaded URL
    const loadContent = (url, linkElement = null) => {
        contentDisplay.innerHTML = '<p class="loading-message">Loading...</p>';

        fetch(url)
            .then((response) => {
                if (!response.ok) {
                    if (response.status === 401) {
                        window.location.href = "../auth/login.php"; // Redirect to login if unauthorized
                        return; // Stop further processing
                    }
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text();
            })
            .then((html) => {
                contentDisplay.innerHTML = html;

                // --- NEW: Store the last loaded URL ---
                try {
                    localStorage.setItem("lastLoadedUrl", url);
                } catch (e) {
                    console.error("Failed to save URL to localStorage:", e);
                }
                // --- END NEW ---

                // Call your modal initialization functions here
                if (typeof initializeAddResidentModal === "function") {
                    initializeAddResidentModal();
                }
                if (
                    typeof initializeSelectCertificateTypeModal === "function"
                ) {
                    initializeSelectCertificateTypeModal();
                }
                if (
                    typeof initializeSelectCertificateTypeModal2 === "function"
                ) {
                    initializeSelectCertificateTypeModal2();
                }
                if (typeof initializeEditResidentModal === "function") {
                    initializeEditResidentModal();
                }
                if (typeof initializeDeleteResidentModal === "function") {
                    initializeDeleteResidentModal();
                }
                if (
                    typeof initializeNewCertificateRequestModal === "function"
                ) {
                    initializeNewCertificateRequestModal();
                }
                if (typeof initializeBanResidentModal === "function") {
                    initializeBanResidentModal();
                }
                if (typeof initializeUnbanResidentModal === "function") {
                    initializeUnbanResidentModal();
                }
                // --- IMPORTANT NEW CALL FOR PAGINATION LISTENERS ---
                // This ensures pagination listeners are attached after content is in the DOM
                if (typeof attachPaginationListeners === "function") {
                    attachPaginationListeners();
                }
                // --- END IMPORTANT NEW CALL --
                // You might need to call other initialization functions here
                // if other dynamically loaded content also requires JS setup.

                // IMPORTANT: Call setActiveLink *after* content is loaded
                // Pass the element that triggered the load and the actual URL that was fetched (including query params)
                setActiveLink(linkElement, url);
            })
            .catch((error) => {
                console.error("Error loading content:", error);
                contentDisplay.innerHTML = `<p class="error-message">Failed to load: ${error.message}</p>`;
            });
    };

    // Handles all clicks with data-load-content
    document.addEventListener("click", (event) => {
        const clickableElement = event.target.closest(
            '[data-load-content="true"]'
        ); // Catches both <a> and <button>

        if (clickableElement) {
            event.preventDefault(); // Prevent default link/button action

            let url =
                clickableElement.getAttribute("href") || // For <a> tags
                clickableElement.getAttribute("data-url"); // For <button> tags

            // Handle data-resident-id for fd_resident_profile.php if the button is clicked
            const residentId =
                clickableElement.getAttribute("data-resident-id");
            if (residentId && url.includes("fd_resident_profile.php")) {
                const separator = url.includes("?") ? "&" : "?";
                url += `${separator}id=${residentId}`;
            }

            if (url) {
                loadContent(url, clickableElement);
            } else {
                console.warn(
                    'Clicked element has data-load-content="true" but no href or data-url attribute:',
                    clickableElement
                );
            }

            // --- Sidebar closing logic ---
            if (
                window.innerWidth <= 600 &&
                sidebar &&
                sidebar.classList.contains("active")
            ) {
                sidebar.classList.remove("active");
                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove("active");
                }
            }
            // --- End of sidebar logic ---
        }
    });

    // ######################################################################
    // # MODIFIED INITIAL LOAD LOGIC TO CHECK LOCALSTORAGE                #
    // ######################################################################
    const lastLoadedUrl = localStorage.getItem("lastLoadedUrl");
    let urlToLoadOnInit = null;
    let initialLinkElement = null;

    if (lastLoadedUrl) {
        urlToLoadOnInit = lastLoadedUrl;
        // Try to find a corresponding link element for the stored URL
        const cleanUrl = lastLoadedUrl.split("?")[0]; // Remove query params for matching
        if (cleanUrl.includes("fd_resident_profile.php")) {
            initialLinkElement = residentProfileA;
        } else {
            initialLinkElement = document.querySelector(
                `.main-nav a[href*="${cleanUrl}"]`
            );
        }
    } else {
        // Default to the first navigation link (Dashboard) if nothing in localStorage
        if (
            navLinks.length > 0 &&
            navLinks[0].tagName === "A" &&
            navLinks[0].href
        ) {
            urlToLoadOnInit = navLinks[0].href;
            initialLinkElement = navLinks[0];
        } else {
            console.warn(
                "No stored URL and no valid first navigation link found for initial load."
            );
            // Fallback if even the first link isn't suitable, e.g., load a fixed dashboard URL
            // urlToLoadOnInit = './fd_dashboard.php';
        }
    }

    if (urlToLoadOnInit) {
        loadContent(urlToLoadOnInit, initialLinkElement);
    }
    // ######################################################################
    // # END OF MODIFIED INITIAL LOAD LOGIC                               #
    // ######################################################################

    // Existing menu toggle and sidebar overlay listeners
    if (menuToggleBtn && sidebar) {
        menuToggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("active");
            if (sidebarOverlay) {
                sidebarOverlay.classList.toggle(
                    "active",
                    sidebar.classList.contains("active")
                );
            }
        });
    }

    if (sidebarOverlay && sidebar) {
        sidebarOverlay.addEventListener("click", (event) => {
            if (event.target === sidebarOverlay) {
                sidebar.classList.remove("active");
                sidebarOverlay.classList.remove("active");
            }
        });
    }
});