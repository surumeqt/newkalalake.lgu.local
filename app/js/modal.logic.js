document.addEventListener('DOMContentLoaded', () => {
    // Existing elements (from your current JS)
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

    // Elements for the Status Modal
    const statusModal = document.getElementById("status-modal");
    const docketInputStatus = document.getElementById("modal-docket-status");
    const statusSelectedValueInput = document.getElementById("status-selected-value");
    const statusForm = document.getElementById("status-form");
    const statusSelectionDropdown = document.getElementById("status-selection");
    const statusReportSummaryGroup = document.getElementById("status-report-summary-group");
    const statusReportSummaryTextarea = document.getElementById("status_report_summary_text");
    const cancelStatusBtn = statusModal ? statusModal.querySelector('.cancel-status-btn') : null;

    // --- NEW: Ensure the modal is hidden on page load ---
    if (statusModal) {
        statusModal.style.display = 'none'; // Explicitly hide it on DOMContentLoaded
    }
    // --- END NEW ---


    // Function to toggle the visibility and required status of the report summary
    const toggleReportSummary = (selectedStatus) => {
        if (statusReportSummaryGroup && statusReportSummaryTextarea) {
            if (selectedStatus === 'Rehearing') {
                statusReportSummaryGroup.style.display = 'none';
                statusReportSummaryTextarea.removeAttribute('required');
                statusReportSummaryTextarea.value = '';
            } else {
                statusReportSummaryGroup.style.display = 'block';
                statusReportSummaryTextarea.setAttribute('required', 'required');
            }
        }
    };

    // Event listener for opening the Status Modal (when "Change Status" button is clicked)
    document.addEventListener("click", function (event) {
        const clickedButton = event.target.closest(".open-lupon-modal");

        if (clickedButton) {
            const docket = clickedButton.getAttribute("data-docket");
            const hearingStatus = clickedButton.getAttribute("data-hearing");

            if (statusModal && docketInputStatus && statusSelectedValueInput && statusForm && statusSelectionDropdown) {
                docketInputStatus.value = docket;
                statusSelectionDropdown.value = ''; // Reset dropdown selection on open
                statusSelectedValueInput.value = ''; // Clear hidden input on open
                statusReportSummaryTextarea.value = ''; // Clear summary on open

                // Initially hide the summary group when the modal opens
                toggleReportSummary(''); // Pass empty string to ensure it hides initially

                statusModal.style.display = "flex"; // This line will show the modal when the button is clicked
                console.log('Opening Status Modal (from cases.php button). Original status:', hearingStatus);
            } else {
                console.warn('Status modal elements not found or misconfigured for .open-lupon-modal.');
            }
        }
    });

    // Event listener for the status dropdown change
    if (statusSelectionDropdown) {
        statusSelectionDropdown.addEventListener('change', function() {
            const selectedStatus = this.value;
            statusSelectedValueInput.value = selectedStatus;
            toggleReportSummary(selectedStatus);
            console.log('Status dropdown changed to:', selectedStatus);
        });
    }

    // Event listener for form submission
    if (statusForm && statusSelectedValueInput) {
        statusForm.addEventListener('submit', function(event) {
            const selectedStatus = statusSelectedValueInput.value;
            const summaryText = statusReportSummaryTextarea.value;
            const isSummaryVisible = statusReportSummaryGroup.style.display !== 'none';

            if (!selectedStatus) {
                alert('Please select a status option.');
                event.preventDefault();
                return;
            }

            if (isSummaryVisible && statusReportSummaryTextarea.hasAttribute('required') && !summaryText.trim()) {
                alert('Please enter the report summary.');
                event.preventDefault();
                return;
            }

            console.log('Submitting Status Form:');
            console.log('Docket:', docketInputStatus.value);
            console.log('Selected Status:', selectedStatus);
            if (isSummaryVisible) {
                console.log('Report Summary:', summaryText);
            }
        });
    }

    // Event listeners for closing the modal
    if (statusModal) {
        statusModal.addEventListener("click", (event) => {
            if (event.target === statusModal) {
                statusModal.style.display = "none";
                if (statusForm) statusForm.reset();
                toggleReportSummary('');
                console.log('Closing Status Modal by clicking overlay.');
            }
        });
    }

    if (cancelStatusBtn) {
        cancelStatusBtn.addEventListener('click', () => {
            if (statusModal) {
                statusModal.style.display = 'none';
                if (statusForm) statusForm.reset();
                toggleReportSummary('');
                console.log('Closing Status Modal via Cancel button.');
            }
        });
    }
});


let currentResidentIdForCertificates = null;

// Function to initialize the Add Resident Modal (existing from your files)
function initializeAddResidentModal() {
    console.log("Attempting to initialize Add Resident Modal..."); // Debugging

    const openModalBtn = document.getElementById("openModalBtn");
    const addResidentModal = document.getElementById("AddresidentModal");
    const closeModalBtn = document.getElementById("closeModalBtn");

    if (openModalBtn && addResidentModal && closeModalBtn) {
        console.log("Add Resident Modal elements found. Attaching listeners.");

        openModalBtn.addEventListener("click", () => {
            addResidentModal.classList.add("active");
            console.log("Add Resident Modal Opened!");
        });

        closeModalBtn.addEventListener("click", () => {
            addResidentModal.classList.remove("active");
            console.log("Add Resident Modal Closed!");
        });

        // Close modal if overlay is clicked
        addResidentModal.addEventListener("click", (event) => {
            if (event.target === addResidentModal) {
                addResidentModal.classList.remove("active");
                console.log("Add Resident Modal Closed by clicking outside!");
            }
        });
    } else {
        console.warn(
            "Could not find all Add Resident Modal elements. This is normal if fd_residents.php is not loaded yet."
        );
        if (!openModalBtn) console.warn("Missing #openModalBtn");
        if (!addResidentModal) console.warn("Missing #AddresidentModal");
        if (!closeModalBtn) console.warn("Missing #closeModalBtn");
    }
}

// NEW FUNCTION: Function to initialize the Select Certificate Type Modal
function initializeSelectCertificateTypeModal() {
    console.log("Attempting to initialize Select Certificate Type Modal..."); // Debugging

    const openModalBtn = document.getElementById("issueCertificateModalBtn");
    const SelectCertificateTypeModal = document.getElementById(
        "SelectCertificateTypeModal"
    );
    const closeModalBtn = document.getElementById("sc-closeModalBtn");

    if (openModalBtn && SelectCertificateTypeModal && closeModalBtn) {
        console.log(
            "Select Certificate Type Modal elements found. Attaching listeners."
        );

        openModalBtn.addEventListener("click", () => {
            SelectCertificateTypeModal.classList.add("active");
            console.log("Select Certificate Type Modal Opened!");
        });

        closeModalBtn.addEventListener("click", () => {
            SelectCertificateTypeModal.classList.remove("active");
            console.log("Select Certificate Type Modal Closed!");
        });

        // Close modal if overlay is clicked
        SelectCertificateTypeModal.addEventListener("click", (event) => {
            if (event.target === SelectCertificateTypeModal) {
                SelectCertificateTypeModal.classList.remove("active");
                console.log(
                    "Select Certificate Type Modal Closed by clicking outside!"
                );
            }
        });
    } else {
        console.warn(
            "Could not find all Select Certificate Type Modal elements. This is normal if fd_residents.php is not loaded yet."
        );
        if (!openModalBtn) console.warn("Missing #issueCertificateModalBtn");
        if (!SelectCertificateTypeModal)
            console.warn("Missing #SelectCertificateTypeModal");
        if (!closeModalBtn) console.warn("Missing #sc-closeModalBtn");
    }
}