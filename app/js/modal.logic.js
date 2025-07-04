document.addEventListener('DOMContentLoaded', () => {
    // === Logout Modal Logic ===
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
    }

    // === Status and Rehearing Modals Logic ===
    const statusModal = document.getElementById("status-modal");
    const rehearingModal = document.getElementById("rehearing-modal");
    const docketInputStatus = document.getElementById("modal-docket-status");
    const docketInputRehearing = document.getElementById("modal-docket-rehearing");

    document.addEventListener("click", function (event) {
        const clickedButton = event.target.closest(".open-lupon-modal");
        
        if (clickedButton) {
            const docket = clickedButton.getAttribute("data-docket");
            const hearingStatus = clickedButton.getAttribute("data-hearing");

            // --- DEBUGGING LOGS START --- // if you want to see the values in the console incase of 'data missing' or 'undefined'
            console.log('--- Modal Button Clicked ---');
            console.log('Docket:', docket);
            console.log('Hearing Status from data-attribute:', hearingStatus);
            console.log('Is hearingStatus === "Rehearing"?', hearingStatus === 'Rehearing');
            // --- DEBUGGING LOGS END ---

            if (hearingStatus === 'Rehearing') {
                if (docketInputRehearing && rehearingModal) {
                    docketInputRehearing.value = docket;
                    rehearingModal.style.display = "flex";
                    console.log('Opening Rehearing Modal.');
                } else {
                    console.warn('Rehearing modal elements not found or misconfigured.');
                }
            } else {
                if (docketInputStatus && statusModal) {
                    docketInputStatus.value = docket;
                    statusModal.style.display = "flex";
                    console.log('Opening Status Modal.');
                } else {
                    console.warn('Status modal elements not found or misconfigured.');
                }
            }
        }
    });

    if (statusModal) {
        statusModal.addEventListener("click", (event) => {
            if (event.target === statusModal) {
                statusModal.style.display = "none";
            }
        });
    }

    if (rehearingModal) {
        rehearingModal.addEventListener("click", (event) => {
            if (event.target === rehearingModal) {
                rehearingModal.style.display = "none";
            }
        });
    }
});