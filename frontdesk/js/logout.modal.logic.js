const logoutButton = document.getElementById('logoutButton');
const logoutModal = document.getElementById('logoutModal');
const confirmLogoutBtn = document.getElementById('confirmLogout');
const cancelLogoutBtn = document.getElementById('cancelLogout');

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
    window.location.href = "/newkalalake.lgu.local/frontdesk/logout.php";
});

