
document.addEventListener('DOMContentLoaded', () => {
    const summaryModal = document.getElementById('summary-modal');
    const modalDocketSummaryInput = document.getElementById('modal-docket-summary');
    const cancelSummaryBtn = document.querySelector('#summary-modal .cancel-summary-btn');

    document.addEventListener('click', function(event) {
        const clickedButton = event.target.closest('.open-summary-modal');

        if (clickedButton && summaryModal && modalDocketSummaryInput) {
            const docket = clickedButton.getAttribute('data-docket');

            modalDocketSummaryInput.value = docket;

            summaryModal.style.display = 'flex';

            console.log(`Opening Summary Modal for Docket: ${docket}`);
        }
    });


    if (summaryModal) {
        summaryModal.addEventListener('click', function(event) {
            if (event.target === summaryModal) {
                summaryModal.style.display = 'none';
                console.log('Closing Summary Modal by clicking overlay.');
            }
        });
    } else {
        console.warn('Summary Modal element (id="summary-modal") not found. Ensure HTML is loaded.');
    }

    if (cancelSummaryBtn) {
        cancelSummaryBtn.addEventListener('click', () => {
            if (summaryModal) {
                summaryModal.style.display = 'none';
                console.log('Closing Summary Modal via Cancel button.');
            }
        });
    }
});