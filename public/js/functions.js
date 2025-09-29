function showLogoutModal(){
    const logoutModal = document.getElementById('logoutModal');
    logoutModal.classList.toggle('show');
}

function showUpdateModal(case_number){
    const updateModal = document.getElementById('updateModal');
    const caseNumber = document.getElementById('case-number-update');

    if (updateModal) {
        updateModal.classList.toggle('show');
        caseNumber.value = case_number;
    }
}

function showDeleteModal(case_number){
    const deleteModal = document.getElementById('deleteModal');
    const caseNumber = document.getElementById('case-number-delete');
    
    if (deleteModal) {
        deleteModal.classList.toggle('show');
        caseNumber.value = case_number;
    }
}

function toggleSidebar() {
    document.querySelector(".sidebar").classList.toggle("collapsed");
}