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
                    const firstNavLink = navLinks[0];
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

            if (window.innerWidth <= 600 && sidebar && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    });

    if (navLinks.length > 0) {
        loadContent(navLinks[0].href, navLinks[0]);
    }

    if (menuToggleBtn && sidebar) {
        menuToggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }
});