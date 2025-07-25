function liveSearch() {
    const docket = document.getElementById('search-input').value;
    const status = document.getElementById('hearing-status-filter').value;

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('SearchByDcn', docket);
    formData.append('Hearing_status', status);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("records-body").innerHTML = xhr.responseText;
        }
    };

    xhr.open("POST", "../backend/filter.records.controller.php", true);
    xhr.send(formData);
}

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

function editResident(residentId) {
    const modal = document.getElementById('edit-resident-modal');
    const idDisplay = document.getElementById('resident-id-display');

    if (modal && idDisplay) {
        idDisplay.textContent = residentId;
        modal.classList.add('show');
    }
}

function closeEditModal() {
    document.getElementById('edit-resident-modal').classList.remove('show');
}


