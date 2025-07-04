document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('nav a[data-load-content="true"]');
    const contentDisplay = document.querySelector('.content-display');
    const pageTitleElement = document.querySelector('.current-page-title');
    const menuToggleBtn = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');

    const setActiveLink = (currentLink) => {
        navLinks.forEach(link => link.classList.remove('active'));
        if (currentLink) currentLink.classList.add('active');
    };

    const updatePageTitle = (title) => {
        if (pageTitleElement) pageTitleElement.textContent = title;
    };

    const loadContent = (url, linkElement = null) => {
        contentDisplay.innerHTML = '<p class="loading-message">Loading...</p>';

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.text();
            })
            .then(html => {
                contentDisplay.innerHTML = html;
                if (linkElement) {
                    setActiveLink(linkElement);
                    updatePageTitle(linkElement.textContent.trim());
                } else {
                    // If no specific link element was passed (e.g., initial load),
                    // try to find the first link to activate and set title.
                    // This handles cases where the initial load might not correspond to a specific click.
                    const firstNavLink = navLinks[0]; // Get the first data-load-content link
                    if (firstNavLink) {
                        setActiveLink(firstNavLink);
                        updatePageTitle(firstNavLink.textContent.trim());
                    }
                }
            })
            .catch(error => {
                console.error('Error loading content:', error);
                contentDisplay.innerHTML = `<p class="error-message">Failed to load: ${error.message}</p>`;
            });
    };

    navLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            loadContent(event.target.href, event.target);
        });
    });

    // Initial load: Load the content of the first link with data-load-content="true"
    if (navLinks.length > 0) {
        loadContent(navLinks[0].href, navLinks[0]);
    }

    if (menuToggleBtn && sidebar) {
        menuToggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('expanded');
        });
    }
});