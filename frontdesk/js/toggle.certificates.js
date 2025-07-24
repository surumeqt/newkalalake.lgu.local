document.addEventListener('change', function(event){
    selectedCertificate = event.target.closest(".certificate-form-control").value;
    const brgyEndorsement = document.getElementById("barangay-endorsement-inputs");
    if(selectedCertificate == 'Barangay Endorsement'){
        brgyEndorsement.classList.remove('hidden');
    }  
})

