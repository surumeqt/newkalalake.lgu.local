document.addEventListener("DOMContentLoaded", () => {
    // Existing elements (from your current JS)
    const logoutButton = document.getElementById("logoutButton");
    const logoutModal = document.getElementById("logoutModal");
    const confirmLogoutBtn = document.getElementById("confirmLogout");
    const cancelLogoutBtn = document.getElementById("cancelLogout");

    if (logoutButton && logoutModal && confirmLogoutBtn && cancelLogoutBtn) {
        logoutButton.addEventListener("click", () => {
            logoutModal.classList.add("active");
        });

        cancelLogoutBtn.addEventListener("click", () => {
            logoutModal.classList.remove("active");
        });

        logoutModal.addEventListener("click", (event) => {
            if (event.target === logoutModal) {
                logoutModal.classList.remove("active");
            }
        });

        confirmLogoutBtn.addEventListener("click", () => {
            window.location.href = "/newkalalake.lgu.local/frontdesk/components/logout.php";
        });
    }

    // Elements for the Status Modal
    const statusModal = document.getElementById("status-modal");
    const docketInputStatus = document.getElementById("modal-docket-status");
    const statusSelectedValueInput = document.getElementById(
        "status-selected-value"
    );
    const statusForm = document.getElementById("status-form");
    const statusSelectionDropdown = document.getElementById("status-selection");
    const statusReportSummaryGroup = document.getElementById(
        "status-report-summary-group"
    );
    const statusReportSummaryTextarea = document.getElementById(
        "status_report_summary_text"
    );
    const cancelStatusBtn = statusModal
        ? statusModal.querySelector(".cancel-status-btn")
        : null;

    // --- NEW: Ensure the modal is hidden on page load ---
    if (statusModal) {
        statusModal.style.display = "none"; // Explicitly hide it on DOMContentLoaded
    }
    // --- END NEW ---

    // Function to toggle the visibility and required status of the report summary
    const toggleReportSummary = (selectedStatus) => {
        if (statusReportSummaryGroup && statusReportSummaryTextarea) {
            if (selectedStatus === "Rehearing") {
                statusReportSummaryGroup.style.display = "none";
                statusReportSummaryTextarea.removeAttribute("required");
                statusReportSummaryTextarea.value = "";
            } else {
                statusReportSummaryGroup.style.display = "block";
                statusReportSummaryTextarea.setAttribute(
                    "required",
                    "required"
                );
            }
        }
    };

    // Event listener for opening the Status Modal (when "Change Status" button is clicked)
    document.addEventListener("click", function (event) {
        const clickedButton = event.target.closest(".open-lupon-modal");

        if (clickedButton) {
            const docket = clickedButton.getAttribute("data-docket");
            const hearingStatus = clickedButton.getAttribute("data-hearing");

            if (
                statusModal &&
                docketInputStatus &&
                statusSelectedValueInput &&
                statusForm &&
                statusSelectionDropdown
            ) {
                docketInputStatus.value = docket;
                statusSelectionDropdown.value = ""; // Reset dropdown selection on open
                statusSelectedValueInput.value = ""; // Clear hidden input on open
                statusReportSummaryTextarea.value = ""; // Clear summary on open

                // Initially hide the summary group when the modal opens
                toggleReportSummary(""); // Pass empty string to ensure it hides initially

                statusModal.style.display = "flex"; // This line will show the modal when the button is clicked
                console.log(
                    "Opening Status Modal (from cases.php button). Original status:",
                    hearingStatus
                );
            } else {
                console.warn(
                    "Status modal elements not found or misconfigured for .open-lupon-modal."
                );
            }
        }
    });

    // Event listener for the status dropdown change
    if (statusSelectionDropdown) {
        statusSelectionDropdown.addEventListener("change", function () {
            const selectedStatus = this.value;
            statusSelectedValueInput.value = selectedStatus;
            toggleReportSummary(selectedStatus);
            console.log("Status dropdown changed to:", selectedStatus);
        });
    }

    // Event listener for form submission
    if (statusForm && statusSelectedValueInput) {
        statusForm.addEventListener("submit", function (event) {
            const selectedStatus = statusSelectedValueInput.value;
            const summaryText = statusReportSummaryTextarea.value;
            const isSummaryVisible =
                statusReportSummaryGroup.style.display !== "none";

            if (!selectedStatus) {
                alert("Please select a status option.");
                event.preventDefault();
                return;
            }

            if (
                isSummaryVisible &&
                statusReportSummaryTextarea.hasAttribute("required") &&
                !summaryText.trim()
            ) {
                alert("Please enter the report summary.");
                event.preventDefault();
                return;
            }

            console.log("Submitting Status Form:");
            console.log("Docket:", docketInputStatus.value);
            console.log("Selected Status:", selectedStatus);
            if (isSummaryVisible) {
                console.log("Report Summary:", summaryText);
            }
        });
    }

    // Event listeners for closing the modal
    if (statusModal) {
        statusModal.addEventListener("click", (event) => {
            if (event.target === statusModal) {
                statusModal.style.display = "none";
                if (statusForm) statusForm.reset();
                toggleReportSummary("");
                console.log("Closing Status Modal by clicking overlay.");
            }
        });
    }

    if (cancelStatusBtn) {
        cancelStatusBtn.addEventListener("click", () => {
            if (statusModal) {
                statusModal.style.display = "none";
                if (statusForm) statusForm.reset();
                toggleReportSummary("");
                console.log("Closing Status Modal via Cancel button.");
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

// Function to initialize the Edit Resident Modal (existing from your files)
function initializeEditResidentModal() {
    console.log("Attempting to initialize Edit Resident Modal..."); // Debugging

    const OpenEditResidentModalBtn = document.getElementById(
        "OpenEditResidentModalBtn"
    );
    const EditResidentModal = document.getElementById("EditResidentModal");
    const CloseEditResidentModalBtn = document.getElementById(
        "CloseEditResidentModalBtn"
    );

    if (
        OpenEditResidentModalBtn &&
        EditResidentModal &&
        CloseEditResidentModalBtn
    ) {
        console.log("Edit Resident Modal elements found. Attaching listeners.");

        OpenEditResidentModalBtn.addEventListener("click", () => {
            EditResidentModal.classList.add("active");
            console.log("Edit Resident Modal Opened!");
        });

        CloseEditResidentModalBtn.addEventListener("click", () => {
            EditResidentModal.classList.remove("active");
            console.log("Edit Resident Modal Closed!");
        });

        // Close modal if overlay is clicked
        EditResidentModal.addEventListener("click", (event) => {
            if (event.target === EditResidentModal) {
                EditResidentModal.classList.remove("active");
                console.log("Edit Resident Modal Closed by clicking outside!");
            }
        });
    } else {
        console.warn(
            "Could not find all Edit Resident Modal elements. This is normal if fd_residents.php is not loaded yet."
        );
        if (!OpenEditResidentModalBtn)
            console.warn("Missing #OpenEditResidentModalBtn");
        if (!EditResidentModal) console.warn("Missing #EditResidentModal");
        if (!CloseEditResidentModalBtn)
            console.warn("Missing #CloseEditResidentModalBtn");
    }
}

// NEW FUNCTION: Function to initialize the Select Certificate Type Modal 2
function initializeSelectCertificateTypeModal2() {
    console.log("Attempting to initialize Select Certificate Type Modal..."); // Debugging

    const openModalBtn = document.getElementById("issueCertificateModalBtn");
    const SelectCertificateTypeModal2 = document.getElementById(
        "SelectCertificateTypeModal2"
    );
    const closeModalBtn = document.getElementById("sc-closeModalBtn");

    if (openModalBtn && SelectCertificateTypeModal2 && closeModalBtn) {
        console.log(
            "Select Certificate Type Modal elements found. Attaching listeners."
        );

        openModalBtn.addEventListener("click", () => {
            SelectCertificateTypeModal2.classList.add("active");
            console.log("Select Certificate Type Modal Opened!");
        });

        closeModalBtn.addEventListener("click", () => {
            SelectCertificateTypeModal2.classList.remove("active");
            console.log("Select Certificate Type Modal Closed!");
        });

        // Close modal if overlay is clicked
        SelectCertificateTypeModal2.addEventListener("click", (event) => {
            if (event.target === SelectCertificateTypeModal2) {
                SelectCertificateTypeModal2.classList.remove("active");
                console.log(
                    "Select Certificate Type Modal Closed by clicking outside!"
                );
            }
        });
    } else {
        console.warn(
            "Could not find all Select Certificate Type Modal elements. This is normal if fd_resident_profile.php is not loaded yet."
        );
        if (!openModalBtn) console.warn("Missing #issueCertificateModalBtn");
        if (!SelectCertificateTypeModal2)
            console.warn("Missing #SelectCertificateTypeModal2");
        if (!closeModalBtn) console.warn("Missing #sc-closeModalBtn");
    }
}

// NEW FUNCTION: Function to delete resident profile
function initializeDeleteResidentModal() {
    console.log("Attempting to initialize Delete Resident Modal..."); // Debugging

    const openModalBtn = document.getElementById("deleteResidentModalBtn");
    const deleteResidentModal = document.getElementById("DeleteResidentModal");
    const closeModalBtn = document.getElementById("dr-closeModalBtn");

    if (openModalBtn && deleteResidentModal && closeModalBtn) {
        console.log(
            "Delete Resident Modal elements found. Attaching listeners."
        );

        openModalBtn.addEventListener("click", () => {
            deleteResidentModal.classList.add("active");
            console.log("Delete Resident Modal Opened!");
        });

        closeModalBtn.addEventListener("click", () => {
            deleteResidentModal.classList.remove("active");
            console.log("Delete Resident Modal Closed!");
        });

        // Close modal if overlay is clicked
        deleteResidentModal.addEventListener("click", (event) => {
            if (event.target === deleteResidentModal) {
                deleteResidentModal.classList.remove("active");
                console.log(
                    "Delete Resident Modal Closed by clicking outside!"
                );
            }
        });
    } else {
        console.warn(
            "Could not find all Delete Resident Modal elements. This is normal if fd_resident_profile.php is not loaded yet."
        );
        if (!openModalBtn) console.warn("Missing #deleteResidentModalBtn");
        if (!deleteResidentModal) console.warn("Missing #DeleteResidentModal");
        if (!closeModalBtn) console.warn("Missing #dr-closeModalBtn");
    }
}


// NEW FUNCTION: Function New Certificate Request Modal
function initializeNewCertificateRequestModal() {
    console.log("Attempting to initialize New Certificate Request Modal..."); // Debugging

    // Changed to querySelectorAll to select all buttons with the class
    const openModalBtns = document.querySelectorAll(
        ".open-new-certificate-modal-btn"
    );
    const newCertificateModal = document.getElementById(
        "NewCertificateRequestModal"
    );
    const closeModalBtn = document.getElementById(
        "CloseNewCertificateRequestModalBtn"
    );
    // Select the hidden input for resident ID within the modal
    const selectedResidentIdInput = document.getElementById("selectedResidentId");
    // Select the disabled input that displays the resident's name within the modal
    const residentSearchInputModal = document.querySelector("#NewCertificateRequestModal #residentSearchInput");
    // Select the span that displays the resident's name in the modal's info section
    const residentNameDisplay = document.getElementById("residentNameDisplay");


    if (openModalBtns.length > 0 && newCertificateModal && closeModalBtn && selectedResidentIdInput && residentSearchInputModal && residentNameDisplay) {
        console.log(
            "New Certificate Modal elements found. Attaching listeners."
        );

        // Iterate over each "Issue" button and attach a click listener
        openModalBtns.forEach(button => {
            button.addEventListener("click", () => {
                // Get the resident ID and name from the data attributes of the clicked button
                const residentId = button.getAttribute("data-resident-id");
                const residentName = button.getAttribute("data-resident-name");

                // Populate the modal fields with the resident's data
                selectedResidentIdInput.value = residentId;
                residentSearchInputModal.value = residentName; // Set the disabled input with the resident's name
                residentNameDisplay.textContent = residentName; // Update the display text
                residentNameDisplay.style.display = 'inline'; // Ensure the name display is visible

                // Reset ban warning visibility (assuming it should be hidden by default when opening for a new resident)
                document.getElementById("residentBanWarning").style.display = 'none';
                document.getElementById("banReasonDisplay").textContent = '';

                // Open the modal
                newCertificateModal.classList.add("active");
                console.log("New Certificate Modal Opened for Resident ID:", residentId, "Name:", residentName);
            });
        });

        // Event listener for closing the modal using the close button
        closeModalBtn.addEventListener("click", () => {
            newCertificateModal.classList.remove("active");
            console.log("New Certificate Modal Closed!");
            // Optionally clear the modal fields on close for the next use
            selectedResidentIdInput.value = '';
            residentSearchInputModal.value = '';
            residentNameDisplay.textContent = 'N/A';
            residentNameDisplay.style.display = 'none';
            document.getElementById("residentBanWarning").style.display = 'none';
            document.getElementById("banReasonDisplay").textContent = '';
        });

        // Event listener for closing the modal by clicking outside (on the overlay)
        newCertificateModal.addEventListener("click", (event) => {
            if (event.target === newCertificateModal) {
                newCertificateModal.classList.remove("active");
                console.log(
                    "New Certificate Modal Closed by clicking outside!"
                );
                // Optionally clear the modal fields on close
                selectedResidentIdInput.value = '';
                residentSearchInputModal.value = '';
                residentNameDisplay.textContent = 'N/A';
                residentNameDisplay.style.display = 'none';
                document.getElementById("residentBanWarning").style.display = 'none';
                document.getElementById("banReasonDisplay").textContent = '';
            }
        });
    } else {
        // Warning messages if elements are not found, useful for debugging
        console.warn(
            "Could not find all New Certificate Modal elements. This is normal if fd_residents.php is not loaded yet or elements have changed."
        );
        if (openModalBtns.length === 0) console.warn("Missing .open-new-certificate-modal-btn elements");
        if (!newCertificateModal) console.warn("Missing #NewCertificateRequestModal");
        if (!closeModalBtn) console.warn("Missing #CloseNewCertificateRequestModalBtn");
        if (!selectedResidentIdInput) console.warn("Missing #selectedResidentId");
        if (!residentSearchInputModal) console.warn("Missing #NewCertificateRequestModal #residentSearchInput");
        if (!residentNameDisplay) console.warn("Missing #residentNameDisplay");
    }
}

function initializeDeleteResidentModal() {
    console.log("Attempting to initialize Delete Resident Modal..."); // Debugging

    const openModalBtn = document.getElementById("deleteResidentModalBtn");
    const deleteResidentModal = document.getElementById("DeleteResidentModal");
    const closeModalBtn = document.getElementById("dr-closeModalBtn");

    if (openModalBtn && deleteResidentModal && closeModalBtn) {
        console.log(
            "Delete Resident Modal elements found. Attaching listeners."
        );

        openModalBtn.addEventListener("click", () => {
            deleteResidentModal.classList.add("active");
            console.log("Delete Resident Modal Opened!");
        });

        closeModalBtn.addEventListener("click", () => {
            deleteResidentModal.classList.remove("active");
            console.log("Delete Resident Modal Closed!");
        });

        // Close modal if overlay is clicked
        deleteResidentModal.addEventListener("click", (event) => {
            if (event.target === deleteResidentModal) {
                deleteResidentModal.classList.remove("active");
                console.log(
                    "Delete Resident Modal Closed by clicking outside!"
                );
            }
        });
    } else {
        console.warn(
            "Could not find all Delete Resident Modal elements. This is normal if fd_resident_profile.php is not loaded yet."
        );
        if (!openModalBtn) console.warn("Missing #deleteResidentModalBtn");
        if (!deleteResidentModal) console.warn("Missing #DeleteResidentModal");
        if (!closeModalBtn) console.warn("Missing #dr-closeModalBtn");
    }
}
// Function to initialize the Ban Resident Modal
function initializeBanResidentModal() {
    console.log("Attempting to initialize Ban Resident Modal..."); // Debugging

    const openModalBtn = document.getElementById("banResidentModalBtn");
    const banResidentModal = document.getElementById("BanResidentModal");
    const closeModalBtn = document.getElementById("br-closeModalBtn");

    if (openModalBtn && banResidentModal && closeModalBtn) {
        console.log("Ban Resident Modal elements found. Attaching listeners.");

        openModalBtn.addEventListener("click", () => {
            banResidentModal.classList.add("active");
            console.log("Ban Resident Modal Opened!");
        });

        closeModalBtn.addEventListener("click", () => {
            banResidentModal.classList.remove("active");
            console.log("Delete Resident Modal Closed!");
        });

        // Close modal if overlay is clicked
        banResidentModal.addEventListener("click", (event) => {
            if (event.target === banResidentModal) {
                banResidentModal.classList.remove("active");
                console.log("Ban Resident Modal Closed by clicking outside!");
            }
        });
    } else {
        console.warn(
            "Could not find all Ban Resident Modal elements. This is normal if fd_resident_profile.php is not loaded yet."
        );
        if (!openModalBtn) console.warn("Missing #banResidentModalBtn");
        if (!banResidentModal) console.warn("Missing #BanResidentModal");
        if (!closeModalBtn) console.warn("Missing #dr-closeModalBtn");
    }
}