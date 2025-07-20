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
});

let currentResidentIdForCertificates = null;

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

// // NEW FUNCTION: Function to initialize the Select Certificate Type Modal
// function initializeSelectCertificateTypeModal() {
//     console.log("Attempting to initialize Select Certificate Type Modal..."); // Debugging

//     const openModalBtn = document.getElementById("issueCertificateModalBtn");
//     const SelectCertificateTypeModal = document.getElementById(
//         "SelectCertificateTypeModal"
//     );
//     const closeModalBtn = document.getElementById("sc-closeModalBtn");

//     if (openModalBtn && SelectCertificateTypeModal && closeModalBtn) {
//         console.log(
//             "Select Certificate Type Modal elements found. Attaching listeners."
//         );

//         openModalBtn.addEventListener("click", () => {
//             SelectCertificateTypeModal.classList.add("active");
//             console.log("Select Certificate Type Modal Opened!");
//         });

//         closeModalBtn.addEventListener("click", () => {
//             SelectCertificateTypeModal.classList.remove("active");
//             console.log("Select Certificate Type Modal Closed!");
//         });

//         // Close modal if overlay is clicked
//         SelectCertificateTypeModal.addEventListener("click", (event) => {
//             if (event.target === SelectCertificateTypeModal) {
//                 SelectCertificateTypeModal.classList.remove("active");
//                 console.log(
//                     "Select Certificate Type Modal Closed by clicking outside!"
//                 );
//             }
//         });
//     } else {
//         console.warn(
//             "Could not find all Select Certificate Type Modal elements. This is normal if fd_residents.php is not loaded yet."
//         );
//         if (!openModalBtn) console.warn("Missing #issueCertificateModalBtn");
//         if (!SelectCertificateTypeModal)
//             console.warn("Missing #SelectCertificateTypeModal");
//         if (!closeModalBtn) console.warn("Missing #sc-closeModalBtn");
//     }
// }

// Function to initialize the Edit Resident Modal (existing from your files)
// frontdesk\js\modal.logic.js

// It should be defined similarly to reflectAge, but targetting the 'edit_' prefixed IDs
function reflectAgeForEditModal() {
    const birthdayInput = document.getElementById("edit_birthDate");
    const ageInput = document.getElementById("edit_age");

    if (birthdayInput && birthdayInput.value) {
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
    } else {
        ageInput.value = "";
    }
}


function initializeEditResidentModal() {
    console.log("Attempting to initialize Edit Resident Modal...");

    const openEditResidentModalBtn = document.getElementById("OpenEditResidentModalBtn");
    const editResidentModal = document.getElementById("EditResidentModal");
    const closeEditResidentModalBtn = document.getElementById("CloseEditResidentModalBtn");

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
    const editPhotoInput = document.getElementById("edit_photo"); // File input for photo


    if (
        openEditResidentModalBtn &&
        editResidentModal &&
        closeEditResidentModalBtn &&
        editFirstName && // Check at least one key field
        editBirthDate && // Ensure all critical fields exist
        editGender &&
        editResidentIdHidden
    ) {
        console.log("Edit Resident Modal elements found. Attaching listeners.");

        editBirthDate.addEventListener('blur', reflectAgeForEditModal);
        editBirthDate.addEventListener('change', reflectAgeForEditModal); // For date pickers

        openEditResidentModalBtn.addEventListener("click", function() { // Use 'function' to bind 'this' correctly
            const residentId = this.dataset.residentId; // Get resident ID from data-resident-id attribute
            console.log("Edit Resident Modal Opened for ID:", residentId);

            if (residentId) {
                // Fetch resident data via AJAX
                fetch(`../backend/fd_controllers/residents.controller.php?resident_id=${residentId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.data) {
                            const residentDataForEdit = data.data;
                            editResidentIdHidden.value = residentDataForEdit.resident_id || '';
                            editFirstName.value = residentDataForEdit.first_name || '';
                            editMiddleName.value = residentDataForEdit.middle_name || '';
                            editLastName.value = residentDataForEdit.last_name || '';
                            editSuffix.value = residentDataForEdit.suffix || '';
                            editBirthDate.value = residentDataForEdit.birthday || ''; // Date needs YYYY-MM-DD
                            editGender.value = residentDataForEdit.gender || '';
                            editCivilStatus.value = residentDataForEdit.civil_status || '';
                            editHouseNumber.value = residentDataForEdit.house_number || ''; // Use house_number from DB
                            editStreet.value = residentDataForEdit.street || '';
                            editPurok.value = residentDataForEdit.purok || '';
                            editBarangay.value = residentDataForEdit.barangay || '';
                            editCity.value = residentDataForEdit.city || '';
                            editContactNumber.value = residentDataForEdit.contact_number || '';
                            editEmail.value = residentDataForEdit.email || '';

                            reflectAgeForEditModal(); // Calculate age after setting birthday
                            editResidentModal.classList.add("active"); // Show modal after populating
                        } else {
                            alert('Error fetching resident data: ' + data.message);
                            console.error('Error fetching resident data:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error during data fetch for edit modal:", error);
                        alert('An error occurred while loading resident data: ' + error.message);
                    });
            } else {
                console.warn("No resident ID found for edit modal.");
                alert("Cannot edit: Resident ID is missing.");
            }
        });

        closeEditResidentModalBtn.addEventListener("click", () => {
            editResidentModal.classList.remove("active");
            console.log("Edit Resident Modal Closed!");
            form.reset(); // Clear the form on close
            editAge.value = ""; // Clear age field specifically
            editPhotoInput.value = ""; // Clear file input
        });

        // Close modal if overlay is clicked
        editResidentModal.addEventListener("click", (event) => {
            if (event.target === editResidentModal) {
                editResidentModal.classList.remove("active");
                console.log("Edit Resident Modal Closed by clicking outside!");
                form.reset(); // Clear the form on close
                editAge.value = ""; // Clear age field specifically
                editPhotoInput.value = ""; // Clear file input
            }
        });

        // Add form submission listener for saving data (AJAX)
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this); // 'this' refers to the form
            // The 'age' field is disabled, so it won't be submitted by default.
            // If you want to ensure it's not sent, or if you make it enabled,
            // you might re-add: formData.delete('age');
            
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
                    editResidentModal.classList.remove('active'); // Close modal
                    // Reload the current page to reflect changes
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
        if (!openEditResidentModalBtn) console.warn("Missing #OpenEditResidentModalBtn");
        if (!editResidentModal) console.warn("Missing #EditResidentModal");
        if (!closeEditResidentModalBtn) console.warn("Missing #CloseEditResidentModalBtn");
        if (!editFirstName) console.warn("Missing #edit_firstName (or other form fields). Check all 'edit_' prefixed IDs.");
        if (!editResidentIdHidden) console.warn("Missing #edit_residentId hidden input.");
    }
}

// // NEW FUNCTION: Function to initialize the Select Certificate Type Modal 2
// function initializeSelectCertificateTypeModal2() {
//     console.log("Attempting to initialize Select Certificate Type Modal..."); // Debugging

//     const openModalBtn = document.getElementById("issueCertificateModalBtn");
//     const SelectCertificateTypeModal2 = document.getElementById(
//         "SelectCertificateTypeModal2"
//     );
//     const closeModalBtn = document.getElementById("sc-closeModalBtn");

//     if (openModalBtn && SelectCertificateTypeModal2 && closeModalBtn) {
//         console.log(
//             "Select Certificate Type Modal elements found. Attaching listeners."
//         );

//         openModalBtn.addEventListener("click", () => {
//             SelectCertificateTypeModal2.classList.add("active");
//             console.log("Select Certificate Type Modal Opened!");
//         });

//         closeModalBtn.addEventListener("click", () => {
//             SelectCertificateTypeModal2.classList.remove("active");
//             console.log("Select Certificate Type Modal Closed!");
//         });

//         // Close modal if overlay is clicked
//         SelectCertificateTypeModal2.addEventListener("click", (event) => {
//             if (event.target === SelectCertificateTypeModal2) {
//                 SelectCertificateTypeModal2.classList.remove("active");
//                 console.log(
//                     "Select Certificate Type Modal Closed by clicking outside!"
//                 );
//             }
//         });
//     } else {
//         console.warn(
//             "Could not find all Select Certificate Type Modal elements. This is normal if fd_resident_profile.php is not loaded yet."
//         );
//         if (!openModalBtn) console.warn("Missing #issueCertificateModalBtn");
//         if (!SelectCertificateTypeModal2)
//             console.warn("Missing #SelectCertificateTypeModal2");
//         if (!closeModalBtn) console.warn("Missing #sc-closeModalBtn");
//     }
// }

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


// NEW FUNCTION: Function New Certificate Request Modal (This is where the new logic goes)
function initializeNewCertificateRequestModal() {
    console.log("Attempting to initialize New Certificate Request Modal..."); // Debugging

    const newCertificateModal = document.getElementById("NewCertificateRequestModal");
    const closeModalBtn = document.getElementById("CloseNewCertificateRequestModalBtn");
    const selectedResidentIdInput = document.getElementById("selectedResidentId");
    const residentSearchInputModal = document.querySelector("#NewCertificateRequestModal #residentSearchInput");
    const residentStatusDisplay = document.getElementById("residentStatusDisplay");
    const residentBanWarning = document.getElementById("residentBanWarning");
    const banReasonDisplay = document.getElementById("banReasonDisplay");
    const generateCertificateBtn = document.getElementById("generateCertificateBtn");

    // --- NEW ELEMENTS FOR DYNAMIC FORMS ---
    const certificateTypeSelect = document.getElementById('selectCertificateType');
    const specificFormSections = document.querySelectorAll('.form-certificate-specific-fields');
    const photoUploadGroup = document.getElementById('photoUploadGroup');
    // --- END NEW ELEMENTS ---

    if (
        newCertificateModal &&
        closeModalBtn &&
        selectedResidentIdInput &&
        residentSearchInputModal &&
        residentStatusDisplay &&
        residentBanWarning &&
        banReasonDisplay &&
        generateCertificateBtn &&
        certificateTypeSelect && // Check for the new elements
        specificFormSections.length > 0 &&
        photoUploadGroup
    ) {
        console.log("New Certificate Modal elements found. Attaching listeners via event delegation.");

        // --- NEW DYNAMIC FORM LOGIC ---
        // Function to hide all specific form sections
        function hideAllSpecificForms() {
            specificFormSections.forEach(section => {
                section.style.display = 'none';
                // Optionally, clear inputs in hidden sections to prevent submitting old data
                section.querySelectorAll('input, textarea').forEach(input => {
                    input.value = ''; // Clear text inputs
                    input.checked = false; // Uncheck checkboxes/radios
                    input.removeAttribute('required'); // Remove required attribute when hidden
                });
            });
        }

        // Function to show the relevant form section
        function showRelevantForm() {
            hideAllSpecificForms(); // Start by hiding everything

            const selectedValue = certificateTypeSelect.value;
            let targetDataAttribute;

            // Determine which data-certificate-type to show based on the selected value
            if (selectedValue === "Certificate of Indigency" ||
                selectedValue === "Barangay Residency" ||
                selectedValue === "Certificate of Non-Residency") {
                targetDataAttribute = "default_purpose";
            } else if (selectedValue === "Barangay Endorsement") {
                targetDataAttribute = "Barangay Endorsement";
            } else if (selectedValue === "Barangay Permit") {
                targetDataAttribute = "Barangay Permit";
            } else if (selectedValue === "Vehicle Clearance") {
                targetDataAttribute = "Vehicle Clearance";
            }
            // Add more else if blocks for other certificate types if they have unique forms

            if (targetDataAttribute) {
                const sectionToShow = document.querySelector(`[data-certificate-type="${targetDataAttribute}"]`);
                if (sectionToShow) {
                    sectionToShow.style.display = 'block'; // Show the specific section
                    // Make inputs in the visible section required if necessary
                    sectionToShow.querySelectorAll('[data-required-if-visible="true"]').forEach(input => {
                        input.setAttribute('required', 'true');
                    });
                }
            }
            // Also handle photo upload visibility here
            if (selectedValue === 'Vehicle Clearance') { // Example: Photo required for Vehicle Clearance
                photoUploadGroup.style.display = 'block';
                // You might want to add a 'required' attribute to the file input here if it's always required for this type
                // photoUploadGroup.querySelector('input[type="file"]').setAttribute('required', 'true');
            } else {
                photoUploadGroup.style.display = 'none';
                // photoUploadGroup.querySelector('input[type="file"]').removeAttribute('required');
            }
        }

        // Event listener for when the certificate type changes
        certificateTypeSelect.addEventListener('change', showRelevantForm);
        // --- END NEW DYNAMIC FORM LOGIC ---


        document.addEventListener("click", (event) => {
            const clickedButton = event.target.closest(
                ".open-new-certificate-modal-btn"
            );

            if (clickedButton) {
                const residentId =
                    clickedButton.getAttribute("data-resident-id");
                const residentName =
                    clickedButton.getAttribute("data-resident-name");

                // Populate the modal fields with the resident's data (initially)
                selectedResidentIdInput.value = residentId;
                residentSearchInputModal.value = residentName;

                // Reset status display and warning before fetching new data
                residentStatusDisplay.textContent = "Loading..."; // Initial status
                residentStatusDisplay.className = ''; // Clear previous classes
                residentBanWarning.style.display = "none";
                banReasonDisplay.textContent = "";
                generateCertificateBtn.disabled = false; // Enable by default

                // Reset certificate type dropdown and hide all specific forms on modal open
                certificateTypeSelect.value = ""; // Reset dropdown to default
                hideAllSpecificForms(); // Hide all type-specific forms
                photoUploadGroup.style.display = 'none'; // Hide photo upload by default

                // Open the modal immediately
                newCertificateModal.classList.add("active");
                console.log(
                    "New Certificate Modal Opened for Resident ID:",
                    residentId,
                    "Name:",
                    residentName
                );


                // Fetch resident status via AJAX
                fetch(
                    "../backend/fd_controllers/residents.controller.php?resident_id=" +
                    residentId
                )
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.json();
                    })
                    .then((data) => {
                        if (data.success && data.data) {
                            const isBanned = data.data.is_banned;

                            if (isBanned === 1) {
                                residentStatusDisplay.textContent = "Banned";
                                residentStatusDisplay.className = 'text-danger'; // Add class for styling
                                residentBanWarning.style.display = "block"; // Show the warning
                                banReasonDisplay.textContent =
                                    "Lupon Case or Pending Due"; // Set static reason as requested
                                generateCertificateBtn.disabled = true; // Disable the button
                                console.log(
                                    `Resident ID ${residentId} is BANNED. Static Reason Displayed.`
                                );
                            } else {
                                residentStatusDisplay.textContent = "Not Banned";
                                residentStatusDisplay.className = 'text-success'; // Add class for styling
                                residentBanWarning.style.display = "none"; // Hide the warning
                                banReasonDisplay.textContent = ""; // Clear the reason
                                generateCertificateBtn.disabled = false; // Ensure button is enabled
                                console.log(
                                    `Resident ID ${residentId} is ACTIVE.`
                                );
                            }
                        } else {
                            console.error(
                                "Failed to fetch resident details:",
                                data.message
                            );
                            // Fallback if data fetching fails
                            residentStatusDisplay.textContent = "Error Loading Status";
                            residentStatusDisplay.className = 'text-warning';
                            residentBanWarning.style.display = "none";
                            generateCertificateBtn.disabled = false;
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching resident status:", error);
                        // In case of network error, ensure button is not disabled unexpectedly
                        residentStatusDisplay.textContent = "Network Error";
                        residentStatusDisplay.className = 'text-warning';
                        residentBanWarning.style.display = "none";
                        generateCertificateBtn.disabled = false;
                    });
            }
        });

        // Event listener for closing the modal using the close button
        closeModalBtn.addEventListener("click", () => {
            newCertificateModal.classList.remove("active");
            console.log("New Certificate Modal Closed!");
            // Clear and reset modal fields on close
            selectedResidentIdInput.value = "";
            residentSearchInputModal.value = "";
            residentStatusDisplay.textContent = "N/A"; // Reset status
            residentStatusDisplay.className = '';
            residentBanWarning.style.display = "none";
            banReasonDisplay.textContent = "";
            generateCertificateBtn.disabled = false; // Reset button state on close

            // --- Reset dynamic form specific elements on close ---
            certificateTypeSelect.value = ""; // Reset dropdown
            hideAllSpecificForms(); // Hide all specific forms
            photoUploadGroup.style.display = 'none'; // Hide photo upload
            // --- END Reset dynamic form specific elements ---
        });

        // Event listener for closing the modal by clicking outside (on the overlay)
        newCertificateModal.addEventListener("click", (event) => {
            if (event.target === newCertificateModal) {
                newCertificateModal.classList.remove("active");
                console.log(
                    "New Certificate Modal Closed by clicking outside!"
                );
                // Clear and reset modal fields on close
                selectedResidentIdInput.value = "";
                residentSearchInputModal.value = "";
                residentStatusDisplay.textContent = "N/A"; // Reset status
                residentStatusDisplay.className = '';
                residentBanWarning.style.display = "none";
                banReasonDisplay.textContent = "";
                generateCertificateBtn.disabled = false; // Reset button state on close

                // --- Reset dynamic form specific elements on close ---
                certificateTypeSelect.value = ""; // Reset dropdown
                hideAllSpecificForms(); // Hide all specific forms
                photoUploadGroup.style.display = 'none'; // Hide photo upload
                // --- END Reset dynamic form specific elements ---
            }
        });

        // Initial state: hide all specific forms when the modal is first initialized
        hideAllSpecificForms();
        photoUploadGroup.style.display = 'none';

    } else {
        console.warn(
            "Could not find all New Certificate Modal elements. This is normal if fd_residents.php is not loaded yet or elements have changed."
        );
        if (!newCertificateModal)
            console.warn("Missing #NewCertificateRequestModal");
        if (!closeModalBtn)
            console.warn("Missing #CloseNewCertificateRequestModalBtn");
        if (!selectedResidentIdInput)
            console.warn("Missing #selectedResidentId");
        if (!residentSearchInputModal)
            console.warn(
                "Missing #NewCertificateRequestModal #residentSearchInput"
            );
        if (!residentStatusDisplay) console.warn("Missing #residentStatusDisplay");
        if (!residentBanWarning) console.warn("Missing #residentBanWarning");
        if (!banReasonDisplay) console.warn("Missing #banReasonDisplay");
        if (!generateCertificateBtn)
            console.warn("Missing #generateCertificateBtn");
        if (!certificateTypeSelect) console.warn("Missing #selectCertificateType (new)");
        if (specificFormSections.length === 0) console.warn("Missing .form-certificate-specific-fields (new)");
        if (!photoUploadGroup) console.warn("Missing #photoUploadGroup (new)");
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
    const confirmBanBtn = document.getElementById("confirmBanResidentBtn"); // New: Get the confirm ban button
    const banResidentIdInput = document.getElementById("banResidentIdInput"); // New: Get the hidden input for resident ID

    if (openModalBtn && banResidentModal && closeModalBtn && confirmBanBtn && banResidentIdInput) {
        console.log("Ban Resident Modal elements found. Attaching listeners.");

        // Store resident ID when the modal opens
        openModalBtn.addEventListener("click", () => {
            const residentId = openModalBtn.getAttribute("data-resident-id");
            banResidentIdInput.value = residentId; // Set the hidden input's value
            banResidentModal.classList.add("active");
            console.log("Ban Resident Modal Opened for Resident ID:", residentId);
        });

        closeModalBtn.addEventListener("click", () => {
            banResidentModal.classList.remove("active");
            console.log("Ban Resident Modal Closed!");
        });

        // Close modal if overlay is clicked
        banResidentModal.addEventListener("click", (event) => {
            if (event.target === banResidentModal) {
                banResidentModal.classList.remove("active");
                console.log("Ban Resident Modal Closed by clicking outside!");
            }
        });

        // Handle the actual banning process when "Yes, Ban" is clicked
        confirmBanBtn.addEventListener("click", () => {
            const residentIdToBan = banResidentIdInput.value;

            if (!residentIdToBan) {
                console.error("No resident ID found to ban.");
                alert("Error: Could not ban resident. Resident ID is missing.");
                banResidentModal.classList.remove("active");
                return;
            }

            // Disable the button to prevent multiple clicks
            confirmBanBtn.disabled = true;
            confirmBanBtn.textContent = 'Banning...';

            // Send AJAX request to the backend
            fetch('../backend/fd_controllers/residents.controller.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=ban_resident&resident_id=${encodeURIComponent(residentIdToBan)}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    banResidentModal.classList.remove("active");
                    // Reload the page to show the updated status
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to ban resident.'));
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('An error occurred while trying to ban the resident. Please try again.');
            })
            .finally(() => {
                // Re-enable the button
                confirmBanBtn.disabled = false;
                confirmBanBtn.textContent = 'Yes, Ban';
            });
        });

    } else {
        console.warn(
            "Could not find all Ban Resident Modal elements. This is normal if fd_resident_profile.php is not loaded yet."
        );
        if (!openModalBtn) console.warn("Missing #banResidentModalBtn");
        if (!banResidentModal) console.warn("Missing #BanResidentModal");
        if (!closeModalBtn) console.warn("Missing #br-closeModalBtn");
        if (!confirmBanBtn) console.warn("Missing #confirmBanResidentBtn");
        if (!banResidentIdInput) console.warn("Missing #banResidentIdInput");
    }
}
function initializeUnbanResidentModal() {
    console.log("Attempting to initialize Unban Resident Modal...");

    const unbanResidentModalBtn = document.getElementById(
        "unbanResidentModalBtn"
    );
    const unbanResidentModal = document.getElementById("UnBanResidentModal");
    const confirmUnBanResidentBtn = document.getElementById(
        "confirmUnBanResidentBtn"
    );
    const closeUnBanModalBtn = document.getElementById("ubr-closeModalBtn");
    const unbanResidentIdInput = document.getElementById(
        "unbanResidentIdInput"
    );
    const residentStatusBadge = document.getElementById("residentStatusBadge"); // To update status visually
    const banResidentModalBtn = document.getElementById("banResidentModalBtn"); // To toggle visibility

    // Ensure all necessary elements are present
    if (
        unbanResidentModalBtn &&
        unbanResidentModal &&
        confirmUnBanResidentBtn &&
        closeUnBanModalBtn &&
        unbanResidentIdInput &&
        residentStatusBadge &&
        banResidentModalBtn
    ) {
        console.log(
            "Unban Resident Modal elements found. Attaching listeners."
        );

        // 1. Open the Unban Modal when the "Unban Resident" button is clicked
        unbanResidentModalBtn.addEventListener("click", function () {
            const residentId = this.dataset.residentId; // Get resident ID from data attribute
            if (residentId) {
                unbanResidentIdInput.value = residentId; // Set the hidden input value
                unbanResidentModal.classList.add("active"); // Show the modal
                console.log("Unban Resident Modal Opened for ID:", residentId);
            } else {
                console.warn("No resident ID found for unban modal button.");
                alert("Cannot unban: Resident ID is missing.");
            }
        });

        // 2. Close the Unban Modal when the "Cancel" button is clicked
        closeUnBanModalBtn.addEventListener("click", () => {
            unbanResidentModal.classList.remove("active");
            unbanResidentIdInput.value = ""; // Clear the hidden input
            console.log("Unban Resident Modal Closed!");
        });

        // 3. Close modal if overlay is clicked
        unbanResidentModal.addEventListener("click", (event) => {
            if (event.target === unbanResidentModal) {
                unbanResidentModal.classList.remove("active");
                unbanResidentIdInput.value = ""; // Clear the hidden input
                console.log("Unban Resident Modal Closed by clicking outside!");
            }
        });

        // 4. Handle the "Confirm Unban" action
        confirmUnBanResidentBtn.addEventListener("click", function () {
            const residentIdToUnban = unbanResidentIdInput.value;

            if (residentIdToUnban) {
                console.log(
                    "Confirming unban for Resident ID:",
                    residentIdToUnban
                );

                // Create FormData to send the action and resident_id
                const formData = new FormData();
                formData.append("action", "unban_resident"); // Corresponds to your PHP switch case
                formData.append("resident_id", residentIdToUnban);

                // Send AJAX request to the backend controller
                fetch("../backend/fd_controllers/residents.controller.php", {
                    method: "POST",
                    body: formData,
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                `HTTP error! Status: ${response.status}`
                            );
                        }
                        return response.json(); // Assuming your backend returns JSON
                    })
                    .then((data) => {
                        console.log("Unban response:", data);
                        if (data.success) {
                            alert("Resident successfully unbanned!");
                            unbanResidentModal.classList.remove("active"); // Close the modal

                            // Update the UI
                            residentStatusBadge.textContent = "Active";
                            residentStatusBadge.classList.remove(
                                "status-banned"
                            );
                            residentStatusBadge.classList.add("status-active");

                            // Toggle button visibility
                            unbanResidentModalBtn.style.display = "none";
                            banResidentModalBtn.style.display = "inline-block";

                            // Optional: Reload the page or update relevant sections if needed
                            // window.location.reload(); // Uncomment if a full reload is preferred
                        } else {
                            alert(
                                "Error unbanning resident: " +
                                    (data.message || "Unknown error.")
                            );
                        }
                    })
                    .catch((error) => {
                        console.error("Error during unban request:", error);
                        alert(
                            "An error occurred during the unban process: " +
                                error.message
                        );
                    });
            } else {
                console.warn("Resident ID not found for unban confirmation.");
                alert("Cannot unban: Resident ID is missing.");
            }
        });
    } else {
        console.warn(
            "Could not find all Unban Resident Modal elements. This is normal if this script runs before the HTML is fully loaded, or if IDs are mismatched."
        );
        if (!unbanResidentModalBtn)
            console.warn("Missing #unbanResidentModalBtn");
        if (!unbanResidentModal) console.warn("Missing #UnBanResidentModal");
        if (!confirmUnBanResidentBtn)
            console.warn("Missing #confirmUnBanResidentBtn");
        if (!closeUnBanModalBtn) console.warn("Missing #ubr-closeModalBtn");
        if (!unbanResidentIdInput)
            console.warn("Missing #unbanResidentIdInput");
        if (!residentStatusBadge) console.warn("Missing #residentStatusBadge");
        if (!banResidentModalBtn) console.warn("Missing #banResidentModalBtn");
    }
}