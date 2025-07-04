document.addEventListener('DOMContentLoaded', () => {
    const logoutButton = document.getElementById('logoutButton');
    const logoutModal = document.getElementById('logoutModal');
    const confirmLogoutBtn = document.getElementById('confirmLogout');
    const cancelLogoutBtn = document.getElementById('cancelLogout');

    if (logoutButton && logoutModal && confirmLogoutBtn && cancelLogoutBtn) {
        logoutButton.addEventListener('click', () => {
            logoutModal.classList.add('active');
        });

        cancelLogoutBtn.addEventListener('click', () => {
            logoutModal.classList.remove('active');
        });

        logoutModal.addEventListener('click', (event) => {
            if (event.target === logoutModal) {
                logoutModal.classList.remove('active');
            }
        });

        confirmLogoutBtn.addEventListener('click', () => {
            window.location.href = '/app/components/logout.php';
        });
    } else {
        console.warn('Logout modal elements not found. Ensure IDs are correct in App.php');
    }
});