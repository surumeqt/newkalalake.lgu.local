document.addEventListener('click', function(event){
    clickedAddResidentButton = event.target.closest(".open-resident-modal");
    const modal = document.getElementById("add-resident-modal");
    const cancelBtn = document.getElementById("cancel-add-resident");
    const openModal = () => modal.classList.add("show");
    const closeModal = () => modal.classList.remove("show");
    if(clickedAddResidentButton){
        openModal();
    }
    if(event.target === cancelBtn){
        closeModal();
    }
})
 