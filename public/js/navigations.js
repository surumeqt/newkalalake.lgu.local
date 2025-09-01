const contentArea = document.getElementById('content-area');

function attachNavListeners() {
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        link.removeEventListener('click', handleNavLinkClick);
        link.addEventListener('click', handleNavLinkClick);
    });
}

function handleNavLinkClick(event) {
    event.preventDefault();
    const pageName = event.target.getAttribute('href').substring(1);
    loadPage(pageName);
}

async function loadPage(pageName) {
    const url = `../backend/helpers/get.content.php?page=${pageName}`;

    try {
        contentArea.innerHTML = `
            <div class="loading-indicator">
                <div class="loading-spinner"></div>
                <p class="loading-text">Loading content...</p>
            </div>
        `;

        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const htmlContent = await response.text();

        contentArea.innerHTML = htmlContent;

        attachNavListeners();

        history.pushState({ page: pageName }, '', `#${pageName}`);

    } catch (error) {
        console.error('Error loading page:', error);
        contentArea.innerHTML = `
            <h2 class="error-heading">Error Loading Page</h2>
            <p class="error-message">Could not load ${pageName} content. Please try again later.</p>
        `;
    }
}

window.addEventListener('DOMContentLoaded', () => {
    attachNavListeners();

    const initialHash = window.location.hash.substring(1);
    if (initialHash) {
        loadPage(initialHash);
    } else {
        loadPage('dashboard');
    }
});

window.addEventListener('popstate', (event) => {
    if (event.state && event.state.page) {
        loadPage(event.state.page);
    } else {
        loadPage('dashboard');
    }
});