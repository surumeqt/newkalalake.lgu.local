// RESIDENTS FUNCTIONALITY

function liveSearch() {
    const docket = document.getElementById('search-input').value;

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('SearchByName', docket);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("residents-table-body").innerHTML = xhr.responseText;
        }
    };

    xhr.open("POST", "../backend/fd_controllers/search.residents.php", true);
    xhr.send(formData);
}

function reflectAge(){
    const birthDateInput = document.getElementById("birthDate");
    const ageInput = document.getElementById("age");

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
        ageInput.value = '';
        ageInput.removeAttribute("readonly");
        alert("Invalid birth date.");
    }
}

// CERTIFICATES PAGE FUNCTIONALITY

function handleCertificateChange(selectElement) {
    const selectedCertificate = selectElement.value;

    const sections = document.querySelectorAll(".certificate-input-section");

    const certificateMap = {
        "Certificate of Indigency": "certificate-indigency-inputs",
        "Barangay Residency": "certificate-residency-inputs",
        "Certificate of Non-Residency": "certificate-nonresidency-inputs",
        "Barangay Permit": "certificate-permit-inputs",
        "Barangay Endorsement": "barangay-endorsement-inputs"
    };

    sections.forEach(section => section.classList.remove("active"));

    const selectedSectionId = certificateMap[selectedCertificate];
    if (selectedSectionId) {
        const selectedSection = document.getElementById(selectedSectionId);
        if (selectedSection) {
        selectedSection.classList.add("active");
        }
    }
}

function fillResidentData(inputElement) {
    const section = inputElement.closest('.certificate-input-section');
    const name = inputElement.value.trim();

    if (name.length < 3) return;

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('name', name);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                if (!response.found) return;

                const map = {
                    'resident-age': 'age',
                    'resident-address': 'address',
                    'resident-birthdate': 'birthday'
                };

                Object.entries(map).forEach(([selector, key]) => {
                    const input = section.querySelector(`.${selector}`);
                    if (input) {
                        input.value = response[key] || '';
                    }
                });

            } catch (e) {
                console.error("JSON parse error", xhr.responseText);
            }
        }
    };

    xhr.open("POST", "../backend/fd_controllers/fill.resident.details.php", true);
    xhr.send(formData);
}

// MODALS OPEN/CLOSE FUNCTIONALITY

function addResident() {
    const modal = document.getElementById('add-resident-modal');
    modal.classList.add('show');
}

function editResident(residentId) {
    const modal = document.getElementById('edit-resident-modal');
    const idDisplay = document.getElementById('resident-id-display');

    if (modal && idDisplay) {
        idDisplay.textContent = residentId;
        modal.classList.add('show');
    }
}

function deleteResident(residentId) {
    const modal = document.getElementById('delete-resident-modal');
    const idDisplay = document.getElementById('resident-id-display-delete');

    if (modal && idDisplay) {
        idDisplay.value = residentId;
        modal.classList.add('show');
    }
}

function closeEditModal() {
    document.getElementById('edit-resident-modal').classList.remove('show');
    document.getElementById('delete-resident-modal').classList.remove('show');
    document.getElementById('add-resident-modal').classList.remove('show');
}


