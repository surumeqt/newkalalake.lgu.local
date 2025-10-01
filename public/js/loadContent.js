function loadContent(url) {
    const mainContentArea = document.getElementById('main-content');
    
    mainContentArea.innerHTML = '<div class="loading-spinner"></div>';

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            mainContentArea.innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading content:', error);
            mainContentArea.innerHTML = '<p style="color: red;">Failed to load content. Please try again later.</p>';
        });
}

function showLogoutModal() {
    const modal = document.getElementById('logoutModal');
    if (modal) {
        modal.classList.add('active');
    }
}

function hideLogoutModal() {
    const modal = document.getElementById('logoutModal');
    if (modal) {
        modal.classList.remove('active');
    }
}

function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle("collapsed");
}

