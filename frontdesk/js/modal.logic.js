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

// frontdesk\js\modal.logic.js
// (Add this function or merge its contents into your existing initializeAddResidentModal if present)

// frontdesk\js\modal.logic.js

function initializeAddResidentModal() {
    console.log("Initializing Add Resident Modal listeners...");
    const birthDateInput = document.getElementById("birthDate");
    const ageInput = document.getElementById("age"); // Get age input as well
    const addResidentModal = document.getElementById("AddresidentModal");
    const closeModalBtn = document.getElementById("closeModalBtn");

    // NEW: Get the button that opens the modal
    const openModalBtn = document.getElementById("openModalBtn");


    if (birthDateInput && ageInput && addResidentModal && closeModalBtn && openModalBtn) {
        console.log("Found all Add Resident Modal elements. Attaching listeners.");

        // Attach the 'blur' event listener to the birthDate input
        // When the birthDate input loses focus, reflectAge() will be called
        birthDateInput.addEventListener('blur', reflectAge);
        
        // Optionally, if you want it to update immediately as date is picked (some date pickers might not trigger blur)
        // birthDateInput.addEventListener('change', reflectAge);

        // NEW: Add event listener for the button that opens the modal
        openModalBtn.addEventListener('click', () => {
            addResidentModal.classList.add('active');
            console.log("Add Resident Modal Opened!");
        });

        // Add event listener for the close button
        closeModalBtn.addEventListener('click', () => {
            addResidentModal.classList.remove('active');
            console.log("Add Resident Modal Closed!");
            // Optional: clear form fields when closing
            document.getElementById('addResidentForm').reset();
            ageInput.value = ""; // Clear age field specifically
        });

        // Add event listener for clicking outside the modal content to close it
        addResidentModal.addEventListener('click', (event) => {
            if (event.target === addResidentModal) {
                addResidentModal.classList.remove('active');
                console.log("Add Resident Modal Closed by clicking outside!");
                document.getElementById('addResidentForm').reset();
                ageInput.value = ""; // Clear age field specifically
            }
        });

    } else {
        console.warn("Could not find all elements for Add Resident Modal initialization. Check IDs and if content is loaded.");
        if (!birthDateInput) console.warn("Missing #birthDate input.");
        if (!ageInput) console.warn("Missing #age input.");
        if (!addResidentModal) console.warn("Missing #AddresidentModal.");
        if (!closeModalBtn) console.warn("Missing #closeModalBtn (for Add Resident Modal).");
        if (!openModalBtn) console.warn("Missing #openModalBtn (for opening Add Resident Modal)."); // NEW warning
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
// frontdesk\js\modal.logic.js

function initializeEditResidentModal() {
    console.log("Attempting to initialize Edit Resident Modal...");

    const OpenEditResidentModalBtn = document.getElementById(
        "OpenEditResidentModalBtn"
    );
    const EditResidentModal = document.getElementById("EditResidentModal");
    const CloseEditResidentModalBtn = document.getElementById(
        "CloseEditResidentModalBtn"
    );

    // Get references to all input fields in the edit modal (using the new 'edit_' prefixed IDs)
    const form = document.getElementById("editResidentForm");
    const editFirstName = document.getElementById("edit_firstName");
    const editMiddleName = document.getElementById("edit_middleName");
    const editLastName = document.getElementById("edit_lastName");
    const editSuffix = document.getElementById("edit_suffix");
    const editBirthDate = document.getElementById("edit_birthDate");
    const editAge = document.getElementById("edit_age"); // This is disabled, updated by reflectAge
    const editGender = document.getElementById("edit_gender");
    const editCivilStatus = document.getElementById("edit_civilStatus");
    const editHouseNumber = document.getElementById("edit_houseNumber");
    const editStreet = document.getElementById("edit_street");
    const editPurok = document.getElementById("edit_purok");
    const editBarangay = document.getElementById("edit_barangay");
    const editCity = document.getElementById("edit_city");
    const editContactNumber = document.getElementById("edit_contact_number");
    const editEmail = document.getElementById("edit_email");
    const editResidentIdHidden = document.getElementById("edit_residentId"); // Hidden ID field
    // const currentResidentPhoto = document.getElementById("currentResidentPhoto"); // If you added img tag for photo


    if (
        OpenEditResidentModalBtn &&
        EditResidentModal &&
        CloseEditResidentModalBtn &&
        editFirstName && // Check at least one key field
        editBirthDate && // Ensure all critical fields exist
        editGender &&
        editResidentIdHidden
    ) {
        console.log("Edit Resident Modal elements found. Attaching listeners.");

        // Add 'blur' listener for birthDate to automatically calculate age
        editBirthDate.addEventListener('blur', () => {
            reflectAgeForEditModal(); // A new specific function for this modal
        });
        // You might also want 'change' for date pickers that don't blur immediately
        // editBirthDate.addEventListener('change', reflectAgeForEditModal);

        OpenEditResidentModalBtn.addEventListener("click", () => {
            EditResidentModal.classList.add("active");
            console.log("Edit Resident Modal Opened!");

            // Populate the form fields with current resident data
            if (residentDataForEdit) {
                editResidentIdHidden.value = residentDataForEdit.resident_id || '';
                editFirstName.value = residentDataForEdit.first_name || '';
                editMiddleName.value = residentDataForEdit.middle_name || '';
                editLastName.value = residentDataForEdit.last_name || '';
                editSuffix.value = residentDataForEdit.suffix || '';
                editBirthDate.value = residentDataForEdit.birthday || ''; // Date fields need YYYY-MM-DD
                // No need to set editAge directly as it's calculated

                // For select elements, set the value directly
                editGender.value = residentDataForEdit.gender || '';
                editCivilStatus.value = residentDataForEdit.civil_status || '';

                editHouseNumber.value = residentDataForEdit.houseNumber || '';
                editStreet.value = residentDataForEdit.street || '';
                editPurok.value = residentDataForEdit.purok || '';
                editBarangay.value = residentDataForEdit.barangay || '';
                editCity.value = residentDataForEdit.city || '';
                editContactNumber.value = residentDataForEdit.contact_number || '';
                editEmail.value = residentDataForEdit.email || '';

                // If you have an image tag for the current photo:
                // if (currentResidentPhoto && residentDataForEdit.photo_path) {
                //     currentResidentPhoto.src = residentDataForEdit.photo_path; // Assuming photo_path is the URL
                //     currentResidentPhoto.style.display = 'block';
                // } else if (currentResidentPhoto) {
                //     currentResidentPhoto.style.display = 'none';
                // }

                // After populating birthDate, reflect the age
                reflectAgeForEditModal();
            } else {
                console.warn("No resident data available to populate the edit modal.");
                // Optionally clear the form if no data is present
                form.reset();
            }
        });

        CloseEditResidentModalBtn.addEventListener("click", () => {
            EditResidentModal.classList.remove("active");
            console.log("Edit Resident Modal Closed!");
            form.reset(); // Clear the form on close
            editAge.value = ""; // Clear age field specifically
        });

        // Close modal if overlay is clicked
        EditResidentModal.addEventListener("click", (event) => {
            if (event.target === EditResidentModal) {
                EditResidentModal.classList.remove("active");
                console.log("Edit Resident Modal Closed by clicking outside!");
                form.reset(); // Clear the form on close
                editAge.value = ""; // Clear age field specifically
            }
        });

        // Add form submission listener for saving data (AJAX)
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this); // 'this' refers to the form
            // You might want to remove the 'age' field from formData if it's disabled and not part of your backend
            formData.delete('age'); 
            
            console.log("Submitting Edit Resident Form...");

            fetch('../backend/fd_controllers/residents.controller.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); // Assuming your backend returns JSON response
            })
            .then(data => {
                console.log("Edit response:", data);
                if (data.success) {
                    alert('Resident updated successfully!');
                    EditResidentModal.classList.remove('active'); // Close modal
                    // OPTIONAL: Reload the content to show updated profile
                    // This assumes loadContent is available from navigations.js
                    // You might need to make loadContent a global function or pass it.
                    // For now, a full page reload is simpler if not using full SPA
                    window.location.reload(); 
                } else {
                    alert('Error updating resident: ' + data.message);
                }
            })
            .catch(error => {
                console.error("Error during resident update:", error);
                alert('An error occurred during update: ' + error.message);
            });
        });

    } else {
        console.warn(
            "Could not find all Edit Resident Modal elements. This is normal if fd_resident_profile.php is not loaded yet, or IDs are mismatched."
        );
        // More specific warnings for debugging
        if (!OpenEditResidentModalBtn) console.warn("Missing #OpenEditResidentModalBtn");
        if (!EditResidentModal) console.warn("Missing #EditResidentModal");
        if (!CloseEditResidentModalBtn) console.warn("Missing #CloseEditResidentModalBtn");
        if (!editFirstName) console.warn("Missing #edit_firstName (or other form fields). Check all 'edit_' prefixed IDs.");
        if (!editResidentIdHidden) console.warn("Missing #edit_residentId hidden input.");
    }
}

// Helper function for age calculation in the edit modal
function reflectAgeForEditModal() {
    const birthdayInput = document.getElementById("edit_birthDate");
    const ageInput = document.getElementById("edit_age");

    if (birthdayInput && ageInput && birthdayInput.value) {
        const birthDate = new Date(birthdayInput.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (
            monthDiff < 0 ||
            (monthDiff === 0 && today.getDate() < birthDate.getDate())
        ) {
            age--;
        }
        ageInput.value = age;
    } else if (ageInput) {
        ageInput.value = "";
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