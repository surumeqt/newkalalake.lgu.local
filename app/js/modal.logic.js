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
            window.location.href = "/app/logout.php";
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

    // Ensure the modal is hidden on page load ---
    if (statusModal) {
        statusModal.style.display = 'none';
    }

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
                statusSelectionDropdown.value = '';
                statusSelectedValueInput.value = '';
                statusReportSummaryTextarea.value = '';

                toggleReportSummary('');

                statusModal.style.display = "flex";
                console.log('Opening Status Modal (from cases.php button). Original status:', hearingStatus);
            } else {
                console.warn('Status modal elements not found or misconfigured for .open-lupon-modal.');
            }
        }
    });

    // Event listener for showing the images
    document.addEventListener('click', function (event) {
        clickedViewButton = event.target.closest(".view-btn");
        if (clickedViewButton) {
            const docket = clickedViewButton.getAttribute("data-docket");
            showGalleryImages(docket);
        }
    });

    // Event listener for deleteing records
    document.addEventListener('click', function (event) {
        clickedViewButton = event.target.closest(".delete-btn");
        if (clickedViewButton) {
            const docket = clickedViewButton.getAttribute("data-docket");
            deleteRecord(docket);
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