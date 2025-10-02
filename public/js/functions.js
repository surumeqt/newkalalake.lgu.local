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

function showSummaryModal(case_number){
    const summaryModal = document.getElementById('addSummaryModal');
    const caseNumber = document.getElementById('case-number-summary');
    
    if (summaryModal) {
        summaryModal.classList.toggle('show');
        caseNumber.value = case_number;
    }
}

function toggleSidebar() {
    document.querySelector(".sidebar").classList.toggle("collapsed");
}

function setActiveLink() {
    const currentPath = window.location.pathname;
    
    const navItems = document.querySelectorAll('.sidebar-nav ul li');

    navItems.forEach(li => {
        const link = li.querySelector('a');

        if (link && link.getAttribute('href') === currentPath) {
            li.classList.add('active-link');
        } else {
            li.classList.remove('active-link');
        }
    });
}

window.addEventListener('DOMContentLoaded', setActiveLink);