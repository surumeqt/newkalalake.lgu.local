// Helper functions (consolidated from previous Canvas)
function getElement(id) {
    return document.getElementById(id);
}

function setInputValue(id, value) {
    const element = getElement(id);
    if (element) {
        element.value = value || ''; // Use empty string for null/undefined values
    }
}

function setTextContent(id, value) {
    const element = getElement(id);
    if (element) {
        element.textContent = value || '';
    }
}

function checkRadioButton(name, value) {
    const radios = document.querySelectorAll(`input[name="${name}"]`);
    radios.forEach(radio => {
        // Convert boolean to string 'true' or 'false' for comparison with radio values
        const stringValue = String(value);
        if (radio.value === stringValue) {
            radio.checked = true;
        } else {
            radio.checked = false; // Uncheck others
        }
    });
}

// --- RESIDENTS FUNCTIONALITY ---

// Live search for residents table
function liveSearch() {
    const docket = document.getElementById("search-input").value;

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append("SearchByName", docket);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("residents-table-body").innerHTML =
                xhr.responseText;
        }
    };

    xhr.open("POST", "../backend/fd_controllers/search.residents.php", true);
    xhr.send(formData);
}

// Age calculation for new resident form
function reflectAge(){
    const birthDateInput = getElement("birthDate");
    const ageInput = getElement("age");

    const birthDateValue = birthDateInput.value;
    if (!birthDateValue) return;

    const today = new Date();
    const birthDate = new Date(birthDateValue);

    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    const dayDiff = today.getDate() - birthDate.getDate();

    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
        age--;
    }

    if (age >= 0) {
        ageInput.value = age;
        ageInput.setAttribute("readonly", true);
    } else {
        ageInput.value = "";
        ageInput.removeAttribute("readonly");
        alert("Invalid birth date."); // Consider replacing alert with a custom message box
    }
}

// Age calculation for edit resident form (resident's age)
function reflectEditAge() {
    const birthDateInput = getElement("editBirthDate");
    const ageInput = getElement("editAge");

    const birthDateValue = birthDateInput.value;
    if (!birthDateValue) return;

    const today = new Date();
    const birthDate = new Date(birthDateValue);

    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    const dayDiff = today.getDate() - birthDate.getDate();

    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
        age--;
    }

    if (age >= 0) {
        ageInput.value = age;
        ageInput.setAttribute("readonly", true);
    } else {
        ageInput.value = "";
        ageInput.removeAttribute("readonly");
        alert("Invalid birth date."); // Consider replacing alert with a custom message box
    }
}

// Age calculation for father's profile in edit resident form
function reflectFatherAge() {
    const birthDateInput = getElement("editFatherBirthDate");
    const ageInput = getElement("editFatherAge");

    const birthDateValue = birthDateInput.value;
    if (!birthDateValue) return;

    const today = new Date();
    const birthDate = new Date(birthDateValue);

    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    const dayDiff = today.getDate() - birthDate.getDate();

    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
        age--;
    }

    if (age >= 0) {
        ageInput.value = age;
        ageInput.setAttribute("readonly", true);
    } else {
        ageInput.value = "";
        ageInput.removeAttribute("readonly");
        alert("Invalid birth date."); // Consider replacing alert with a custom message box
    }
}

// Age calculation for mother's profile in edit resident form
function reflectMotherAge() {
    const birthDateInput = getElement("editMotherBirthDate");
    const ageInput = getElement("editMotherAge");

    const birthDateValue = birthDateInput.value;
    if (!birthDateValue) return;

    const today = new Date();
    const birthDate = new Date(birthDateValue);

    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    const dayDiff = today.getDate() - birthDate.getDate();

    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
        age--;
    }

    if (age >= 0) {
        ageInput.value = age;
        ageInput.setAttribute("readonly", true);
    } else {
        ageInput.value = "";
        ageInput.removeAttribute("readonly");
        alert("Invalid birth date."); // Consider replacing alert with a custom message box
    }
}

// --- CERTIFICATES PAGE FUNCTIONALITY ---

// Handles visibility of certificate input sections based on selected certificate type
function handleCertificateChange(selectElement) {
    const selectedCertificate = selectElement.value;
    const sections = document.querySelectorAll(".certificate-input-section");
    const placeholder = document.getElementById(
        "select-certificate-placeholder"
    );
    const certificateMap = {
        "Certificate of Indigency": "certificate-indigency-inputs",
        "Barangay Residency": "certificate-residency-inputs",
        "Barangay Clearance": "certificate-clearance-inputs",
        "Certificate of Non-Residency": "certificate-nonresidency-inputs",
        "Certification for 1st time Job Seekers": "certificate-js-inputs",
        "Certification for Low Income": "certificate-lowIncome-inputs",
        "Oath of Undertaking": "certificate-oath-inputs",
        "Barangay Permit": "certificate-permit-inputs",
        "Barangay Endorsement": "barangay-endorsement-inputs",
        "Vehicle Clearance": "vehicle-clearance-inputs",
    };

    sections.forEach((section) => {
        section.classList.remove("active");
        const inputs = section.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.setAttribute('disabled', 'disabled');
            if (input.type !== 'submit' && input.type !== 'button') {
                input.value = ''; // Clear values of hidden inputs
            }
        });
    });

    // --- NEW LOGIC FOR PLACEHOLDER VISIBILITY ---
    if (placeholder) {
        // Ensure placeholder element exists
        if (selectedCertificate === "") {
            // Assuming "" is the value for your default/placeholder option
            placeholder.style.display = "block"; // Show the placeholder
        } else {
            placeholder.style.display = "none"; // Hide the placeholder
        }
    }
    // --- END NEW LOGIC ---
    
    const selectedSectionId = certificateMap[selectedCertificate];
    if (selectedSectionId) {
        const selectedSection = getElement(selectedSectionId);
        if (selectedSection) {
            selectedSection.classList.add("active");
            const activeInputs = selectedSection.querySelectorAll(
                "input, textarea, select"
            );
            activeInputs.forEach((input) => {
                input.removeAttribute("disabled");
            });
        }
    }
}

// Autofills resident data in certificate forms based on name input
function fillResidentData(inputElement) {
    const section = inputElement.closest(".certificate-input-section");
    const name = inputElement.value.trim();

    if (name.length < 3) return; // Only search if name is at least 3 characters long

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append("name", name);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                if (!response.found) return; // If resident not found, do nothing

                // Map of local input IDs/classes to backend response keys
                const map = {
                    'resident-age': 'age',
                    'resident-address': 'address',
                    'resident-birthdate': 'birthday',
                    'resident-monthly-salary': 'monthly_income', // Added for low income cert
                    'resident-occupation': 'occupation',         // Added for low income cert
                    'resident-business-name': 'business_name',   // Added for endorsement
                    'resident-business-address': 'business_address' // Added for endorsement
                };

                Object.entries(map).forEach(([selector, key]) => {
                    const input = section.querySelector(`.${selector}`); // Using class selector as per HTML
                    if (input) {
                        input.value = response[key] || "";
                    }
                });
            } catch (e) {
                console.error("JSON parse error in fillResidentData:", xhr.responseText, e);
            }
        }
    };

    xhr.open(
        "POST",
        "../backend/fd_controllers/fill.resident.details.php",
        true
    );
    xhr.send(formData);
}

function loadDashboardStats() {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        const metrics = response.metrics;
                        const demographics = response.demographics;
                        const activities = response.recent_activities;
                        console.log("metrics: ", metrics);
                        // Update Metrics
                        setTextContent('total-residents-metric', metrics.total_residents);
                        setTextContent('residents-registered-today-metric', metrics.residents_registered_today);
                        setTextContent('total-certificates-issued-metric', metrics.total_certificates_issued);
                        setTextContent('certificates-issued-today-metric', metrics.certificates_issued_today);

                        // Update current dates
                        const today = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        setTextContent('current-date-total-residents', today);
                        setTextContent('current-date-registered-today', today);
                        setTextContent('current-date-certificates-today', today);


                        // Update Gender Distribution Chart
                        const maleCount = demographics.gender.Male;
                        const femaleCount = demographics.gender.Female;
                        const totalGender = maleCount + femaleCount;

                        const maleHeight = totalGender > 0 ? (maleCount / totalGender) * 100 : 0;
                        const femaleHeight = totalGender > 0 ? (femaleCount / totalGender) * 100 : 0;

                        const genderMaleBar = getElement('gender-male-bar');
                        const genderFemaleBar = getElement('gender-female-bar');
                        const genderMaleCountSpan = getElement('gender-male-count');
                        const genderFemaleCountSpan = getElement('gender-female-count');

                        if (genderMaleBar) {
                            genderMaleBar.style.height = `${maleHeight}%`;
                            genderMaleBar.title = `Male: ${maleCount}`;
                        }
                        if (genderFemaleBar) {
                            genderFemaleBar.style.height = `${femaleHeight}%`;
                            genderFemaleBar.title = `Female: ${femaleCount}`;
                        }
                        if (genderMaleCountSpan) genderMaleCountSpan.textContent = maleCount;
                        if (genderFemaleCountSpan) genderFemaleCountSpan.textContent = femaleCount;

                        // Update Age Group Distribution Chart
                        const ageGroups = demographics.age_groups;
                        const ageGroupKeys = ['0-17', '18-35', '36-60', '60+'];
                        let maxAgeCount = 0;
                        ageGroupKeys.forEach(key => {
                            if (ageGroups[key] > maxAgeCount) {
                                maxAgeCount = ageGroups[key];
                            }
                        });

                        ageGroupKeys.forEach(key => {
                            const barElement = getElement(`age-${key.replace(/[^a-zA-Z0-9]/g, '-')}-bar`);
                            const countElement = getElement(`age-${key.replace(/[^a-zA-Z0-9]/g, '-')}-count`);
                            const count = ageGroups[key] || 0;
                            const height = maxAgeCount > 0 ? (count / maxAgeCount) * 100 : 0;

                            if (barElement) {
                                barElement.style.height = `${height}%`;
                                barElement.title = `${key}: ${count}`;
                            }
                            if (countElement) {
                                countElement.textContent = count;
                            }
                        });


                        // Update Recent Activities
                        const activitiesList = getElement('recent-activities-list');
                        if (activitiesList) {
                            activitiesList.innerHTML = ''; // Clear existing activities
                            if (activities.length > 0) {
                                activities.forEach(activity => {
                                    const listItem = document.createElement('li');
                                    const date = new Date(activity.activity_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                                    listItem.innerHTML = `<strong>${date}:</strong> ${activity.description}`;
                                    activitiesList.appendChild(listItem);
                                });
                            } else {
                                const listItem = document.createElement('li');
                                listItem.textContent = 'No recent activities.';
                                activitiesList.appendChild(listItem);
                            }
                        }

                    } else {
                        console.error("Error fetching dashboard data:", response.message);
                    }
                } catch (e) {
                    console.error("JSON parse error for dashboard data:", e, xhr.responseText);
                }
            } else {
                console.error("Network error fetching dashboard data. Status:", xhr.status, xhr.statusText);
            }
        }
    };

    xhr.open("GET", "../backend/fd_controllers/get.dashboard.stats.php", true);
    xhr.send();
}

// --- MODALS OPEN/CLOSE AND HELPERS FUNCTIONALITY ---

// Opens the add resident modal
function addResident() {
    const modal = getElement('add-resident-modal');
    if (modal) {
        modal.classList.add('show');
    }
}

function openEditModal(residentId) {
    const editModal = getElement('edit-resident-modal');
    const modalLoader = getElement('modal-loader');
    const editForm = getElement('edit-resident-form');

    if (editModal && modalLoader && editForm) {
        editModal.classList.add('show'); // Show the modal container
        modalLoader.style.display = 'flex'; // Show the loader
        editForm.style.display = 'none';    // Hide the form initially

        // Set the resident ID display immediately
        setInputValue('resident-id-display', residentId);

        // Now, populate the rest of the form
        populateEditModal(residentId);
    } else {
        console.error("One or more modal elements for edit modal not found.");
    }
}

function populateEditModal(residentId) {
    const modalLoader = getElement('modal-loader');
    const editForm = getElement('edit-resident-form');
    const certificatesTableBody = getElement('certificates-table-body'); // Get the tbody element

    if (!residentId) {
        console.error("Resident ID is required to populate the modal.");
        if (modalLoader) modalLoader.style.display = 'none'; // Hide loader on error
        return;
    }

    // Fetch main resident details
    const xhrResident = new XMLHttpRequest();
    const formDataResident = new FormData();
    formDataResident.append('resident_id', residentId);

    xhrResident.onreadystatechange = function () {
        if (xhrResident.readyState === 4) { // Request is complete
            if (modalLoader) modalLoader.style.display = 'none'; // Hide loader regardless of success/failure

            if (xhrResident.status === 200) {
                try {
                    const response = JSON.parse(xhrResident.responseText);
                    if (response.found && response.data) {
                        const resident = response.data;

                        // --- Section 1: .profile-header-content ---
                        // Profile Image
                        const profileImage = document.querySelector('.profile-image img');
                        if (profileImage) {
                            let photoData = resident.photo;
                            // Check if photoData is a JSON string (e.g., "[\"base64string\"]")
                            if (typeof photoData === 'string' && photoData.startsWith('["') && photoData.endsWith('"]')) {
                                try {
                                    // Attempt to parse it as JSON to get the actual base64 string
                                    const parsedPhoto = JSON.parse(photoData);
                                    if (Array.isArray(parsedPhoto) && parsedPhoto.length > 0) {
                                        photoData = parsedPhoto[0]; // Get the first element of the array
                                    }
                                } catch (e) {
                                    console.error("Error parsing photo data as JSON:", e, photoData);
                                    photoData = null; // Reset if parsing fails
                                }
                            }
                            profileImage.src = photoData ? `data:image/jpeg;base64,${photoData}` : 'images/logo.png';
                            // Fallback to default image if photoData is null or empty
                            profileImage.onerror = function() {
                                this.src = 'images/logo.png';
                            };
                        }

                        // Profile Meta Info
                        // resident-id-display is already set in openEditModal
                        const profileStatusSpan = document.querySelector('.profile-status');
                        if (profileStatusSpan) {
                            profileStatusSpan.textContent = resident.status || 'N/A';
                        }

                        const dateRegisteredSpan = document.querySelector('.profile-meta-info p:nth-child(3) span');
                        if (dateRegisteredSpan) {
                            dateRegisteredSpan.textContent = resident.resident_registered_at ? new Date(resident.resident_registered_at).toLocaleDateString() : 'N/A';
                        }

                        const lastUpdatedSpan = document.querySelector('.profile-meta-info p:nth-child(4) span');
                        if (lastUpdatedSpan) {
                            lastUpdatedSpan.textContent = resident.added_info_last_updated ? new Date(resident.added_info_last_updated).toLocaleDateString() : 'N/A';
                        }

                        // --- Section 2 & 3: .basic-info-section and .profile-section (all .info-group inputs/selects) ---
                        // Resident Personal Information
                        setInputValue('editFirstName', resident.first_name);
                        setInputValue('editMiddleName', resident.middle_name);
                        setInputValue('editLastName', resident.last_name);
                        setInputValue('editSuffix', resident.suffix);
                        setInputValue('editBirthDate', resident.birthday); // Assuming format 'YYYY-MM-DD'
                        setInputValue('editAge', resident.age);
                        setInputValue('editGender', resident.gender);
                        setInputValue('editCivilStatus', resident.civil_status);
                        setInputValue('editIsDeceased', resident.is_deceased ? 'true' : 'false');
                        setInputValue('editDeceasedDate', resident.deceased_date); // Now that the input exists
                        setInputValue('editAddress', resident.address);
                        setInputValue('editEducationalAttainment', resident.educational_attainment);
                        setInputValue('editOccupation', resident.occupation);
                        setInputValue('editjobTitle', resident.job_title);
                        setInputValue('editMonthlyIncome', resident.monthly_income);
                        setInputValue('editContactNo', resident.contact_number);
                        setInputValue('editEmail', resident.email);

                        // Emergency Contact
                        setInputValue('editEmergencyContactName', resident.emergency_contact_name);
                        setInputValue('editEmergencyContactRelationship', resident.emergency_contact_relationship);
                        setInputValue('editEmergencyContactNo', resident.emergency_contact_no);

                        // Business Information
                        checkRadioButton('haveABusiness', resident.have_a_business);
                        setInputValue('editBusinessName', resident.business_name);
                        setInputValue('editBusinessAddress', resident.business_address);

                        // Father's Profile
                        setInputValue('editFatherFirstName', resident.father_first_name);
                        setInputValue('editFatherMiddleName', resident.father_middle_name);
                        setInputValue('editFatherLastName', resident.father_last_name);
                        setInputValue('editFatherSuffix', resident.father_suffix);
                        setInputValue('editFatherBirthDate', resident.father_birth_date);
                        setInputValue('editFatherAge', resident.father_age);
                        setInputValue('editFatherOccupation', resident.father_occupation);
                        setInputValue('editFatherIsDeceased', resident.father_is_deceased ? 'true' : 'false');
                        setInputValue('editFatherDeceasedDate', resident.father_deceased_date); // Now that the input exists
                        setInputValue('editFatherEducationalAttainment', resident.father_educational_attainment);
                        setInputValue('editFatherContactNo', resident.father_contact_no);

                        // Mother's Profile
                        setInputValue('editMotherFirstName', resident.mother_first_name);
                        setInputValue('editMotherMiddleName', resident.mother_middle_name);
                        setInputValue('editMotherLastName', resident.mother_last_name);
                        setInputValue('editMotherSuffix', resident.mother_suffix);
                        setInputValue('editMotherBirthDate', resident.mother_birth_date);
                        setInputValue('editMotherAge', resident.mother_age);
                        setInputValue('editMotherOccupation', resident.mother_occupation);
                        setInputValue('editMotherIsDeceased', resident.mother_is_deceased ? 'true' : 'false');
                        setInputValue('editMotherDeceasedDate', resident.mother_deceased_date); // Now that the input exists
                        setInputValue('editMotherEducationalAttainment', resident.mother_educational_attainment);
                        setInputValue('editMotherContactNo', resident.mother_contact_no);

                        // Siblings
                        setInputValue('editBrothers', resident.num_brothers);
                        setInputValue('editSisters', resident.num_sisters);
                        setInputValue('editOrderOfBirth', resident.order_of_birth);

                        // --- Trigger conditional visibility functions ---
                        if (typeof toggleOccupationVisibility === 'function') {
                            toggleOccupationVisibility();
                        }
                        if (typeof toggleBusinessVisibility === 'function') {
                            toggleBusinessVisibility();
                        }
                        if (typeof toggleDeceasedDate === 'function') {
                            toggleDeceasedDate('resident');
                            toggleDeceasedDate('father');
                            toggleDeceasedDate('mother');
                        }

                        if (editForm) editForm.style.display = 'block'; // Show the form after populating

                        // --- Fetch and populate certificates ---
                        fetchCertificatesForResident(residentId);

                    } else {
                        console.warn("Resident not found or no data returned:", response.message);
                        // Optionally display an error message to the user within the modal
                    }
                } catch (e) {
                    console.error("JSON parse error or data population error:", e, xhrResident.responseText);
                    // Optionally display a generic error message
                }
            } else {
                console.error("Error fetching resident data. Status:", xhrResident.status, xhrResident.statusText);
                // Optionally display a network error message
            }
        }
    };

    xhrResident.open("POST", "../backend/fd_controllers/fill.edit.resident.modal.php", true);
    xhrResident.send(formDataResident);
}

function fetchCertificatesForResident(residentId) {
    const certificatesTableBody = getElement('certificates-table-body');
    if (!certificatesTableBody) {
        console.error("Certificates table body not found.");
        return;
    }

    // Clear previous certificates and show a loading message for certificates
    certificatesTableBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Loading certificates...</td></tr>';

    const xhrCertificates = new XMLHttpRequest();
    const formDataCertificates = new FormData();
    formDataCertificates.append('resident_id', residentId);

    xhrCertificates.onreadystatechange = function () {
        if (xhrCertificates.readyState === 4 && xhrCertificates.status === 200) {
            try {
                const response = JSON.parse(xhrCertificates.responseText);
                console.log('response: ', xhrCertificates.responseText);
                if (response.success && response.certificates) {
                    certificatesTableBody.innerHTML = ''; // Clear loading message

                    if (response.certificates.length > 0) {
                        response.certificates.forEach(cert => {
                            const row = certificatesTableBody.insertRow();
                            row.insertCell().textContent = cert.certificate_type || 'N/A';
                            row.insertCell().textContent = cert.purpose || 'N/A';
                            row.insertCell().textContent = cert.created_at ? new Date(cert.created_at).toLocaleDateString() : 'N/A';
                            row.insertCell().textContent = cert.issued_by || 'N/A';
                            
                            const documentCell = row.insertCell();
                            if (cert.id) { // We need the certificate ID to fetch the blob
                                const downloadBtn = document.createElement('button');
                                downloadBtn.textContent = 'Download Document';
                                downloadBtn.classList.add('btn', 'btn-download'); // Add some styling classes
                                downloadBtn.onclick = function() {
                                    downloadCertificate(cert.id, cert.resident_id, cert.certificate_type);
                                };
                                documentCell.appendChild(downloadBtn);
                            } else {
                                documentCell.textContent = 'N/A';
                            }
                        });
                    } else {
                        certificatesTableBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No certificate history available.</td></tr>';
                    }
                } else {
                    console.warn("Error fetching certificates:", response.message);
                    certificatesTableBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Failed to load certificates.</td></tr>';
                }
            } catch (e) {
                console.error("JSON parse error in fetchCertificatesForResident:", e, xhrCertificates.responseText);
                certificatesTableBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Error parsing certificate data.</td></tr>';
            }
        } else if (xhrCertificates.readyState === 4) {
            console.error("Error fetching certificates. Status:", xhrCertificates.status, xhrCertificates.statusText);
            certificatesTableBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Network error fetching certificates.</td></tr>';
        }
    };

    xhrCertificates.open("POST", "../backend/fd_controllers/get.resident.certificates.php", true);
    xhrCertificates.send(formDataCertificates);
}

function downloadCertificate(certificateId, resident_id, certificate_type) {
    if (!certificateId) {
        console.error("Certificate ID is required to download the document.");
        return;
    }
    const downloadUrl = `../backend/fd_controllers/view.certificate.php?id=${certificateId}&download=true`;

    const link = document.createElement('a');
    link.href = downloadUrl;
    link.download = `${resident_id}_${certificate_type}.pdf`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Opens the delete resident modal
function deleteResident(residentId) {
    const modal = getElement('delete-resident-modal');
    const idDisplay = getElement('resident-id-display-delete');

    if (modal && idDisplay) {
        idDisplay.value = residentId;
        modal.classList.add("show");
    }
}

/**
 * Hides all modals and resets their state.
 */
function closeEditModal() {
    const editModal = getElement('edit-resident-modal');
    const modalLoader = getElement('modal-loader');
    const editForm = getElement('edit-resident-form');

    // Hide the edit modal and its components
    if (editModal) editModal.classList.remove('show');
    if (modalLoader) modalLoader.style.display = 'none';
    if (editForm) {
        editForm.style.display = 'none';
        editForm.reset(); // Resets all form elements to their initial values
    }

    // Reset specific display elements in the edit modal
    setInputValue('resident-id-display', '');
    const profileStatusSpan = document.querySelector('.profile-status');
    if (profileStatusSpan) profileStatusSpan.textContent = '';
    const dateRegisteredSpan = document.querySelector('.profile-meta-info p:nth-child(3) span');
    if (dateRegisteredSpan) dateRegisteredSpan.textContent = '';
    const lastUpdatedSpan = document.querySelector('.profile-meta-info p:nth-child(4) span');
    if (lastUpdatedSpan) lastUpdatedSpan.textContent = '';
    const profileImage = document.querySelector('.profile-image img');
    if (profileImage) profileImage.src = 'images/logo.png'; // Reset to default placeholder

    // Also reset visibility of conditional sections in the edit modal
    if (typeof toggleOccupationVisibility === 'function') {
        setInputValue('editOccupation', '');
        toggleOccupationVisibility();
    }
    if (typeof toggleBusinessVisibility === 'function') {
        checkRadioButton('haveABusiness', ''); // Uncheck all
        toggleBusinessVisibility();
    }
    if (typeof toggleDeceasedDate === 'function') {
        setInputValue('editIsDeceased', 'false');
        toggleDeceasedDate('resident');
        setInputValue('editFatherIsDeceased', 'false');
        toggleDeceasedDate('father');
        setInputValue('editMotherIsDeceased', 'false');
        toggleDeceasedDate('mother');
    }

    // Also close other modals if they are open (original behavior from your functions.js)
    const deleteModal = getElement('delete-resident-modal');
    if (deleteModal) deleteModal.classList.remove('show');
    const addModal = getElement('add-resident-modal');
    if (addModal) addModal.classList.remove('show');
}

// --- CONDITIONAL VISIBILITY FUNCTIONS ---

// Toggles visibility of business-related input fields
function toggleBusinessVisibility() {
    const haveABusinessYes = getElement("haveABusinessYes"); // radio button
    const haveABusinessNo = getElement("haveABusinessNo"); // radio button
    const zxcvDiv = getElement("zxcv"); // hidden div to show

    if (zxcvDiv) { // Ensure the container exists
        if (haveABusinessYes && haveABusinessYes.checked) {
            zxcvDiv.style.display = "block";
        } else if (haveABusinessNo && haveABusinessNo.checked) {
            zxcvDiv.style.display = "none";
            // Clear values when hidden
            setInputValue('editBusinessName', '');
            setInputValue('editBusinessAddress', '');
        } else {
            // Default state if neither is checked (e.g., on initial load)
            zxcvDiv.style.display = "none";
            setInputValue('editBusinessName', '');
            setInputValue('editBusinessAddress', '');
        }
    }
}

// Toggles visibility of job title and monthly income fields based on occupation
function toggleOccupationVisibility() {
    const editOccupation = getElement("editOccupation"); // select tag
    const editjobTitleContainer = getElement("editJobTitleContainer"); // hidden div to show
    const editMonthlyIncomeContainer = getElement("editMonthlyIncomeContainer"); // hidden div to show

    if (editjobTitleContainer && editMonthlyIncomeContainer) { // Ensure containers exist
        if (editOccupation && editOccupation.value === "Employed") {
            editjobTitleContainer.style.display = "block";
            editMonthlyIncomeContainer.style.display = "block";
        } else {
            editjobTitleContainer.style.display = "none";
            editMonthlyIncomeContainer.style.display = "none";
            // Clear values when hidden
            setInputValue('editjobTitle', '');
            setInputValue('editMonthlyIncome', '');
        }
    }
}

// Toggles visibility of deceased date input based on status (resident, father, mother)
function toggleDeceasedDate(personType) {
    let selectElement, dateContainerId;

    if (personType === 'resident') {
        selectElement = getElement('editIsDeceased');
        dateContainerId = 'editDeceasedDateContainer';
    } else if (personType === 'father') {
        selectElement = getElement('editFatherIsDeceased');
        dateContainerId = 'editFatherDeceasedDateContainer';
    } else if (personType === 'mother') {
        selectElement = getElement('editMotherIsDeceased');
        dateContainerId = 'editMotherDeceasedDateContainer';
    } else {
        return;
    }

    const dateContainer = getElement(dateContainerId);

    if (selectElement && dateContainer) {
        if (selectElement.value === 'true') {
            dateContainer.style.display = 'block';
        } else {
            dateContainer.style.display = 'none';
            const dateInput = dateContainer.querySelector('input[type="date"]');
            if (dateInput) {
                dateInput.value = '';
            }
        }
    }
}