document.addEventListener('change', function(event){
    selectedCertificate = event.target.closest(".certificate-form-control").value;
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
});

