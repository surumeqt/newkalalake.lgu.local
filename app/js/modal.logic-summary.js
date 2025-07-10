document.addEventListener('DOMContentLoaded', () => {
    const combinedActionModal = document.getElementById('summary-modal');
    const modalDocketInput = document.getElementById('modal-docket-summary');
    const reportSummaryTextarea = document.getElementById('report_summary_text');
    const actionSelection = document.getElementById('action-selection');
    const combinedActionForm = document.getElementById('summary-form');
    const cancelCombinedBtn = document.querySelector('#summary-modal .cancel-summary-btn');
    const modalSelectedStatusForSubmit = document.getElementById('modal-selected-status-for-submit');

    // New elements for controlling the "Next Hearing Date" field
    const nextHearingDateGroup = document.getElementById('next-hearing-date-group');
    const nextHearingDateLabel = nextHearingDateGroup ? nextHearingDateGroup.querySelector('.summary-label') : null;
    const nextHearingDateInput = document.getElementById('next_hearing_date');

    // Function to show/hide the next hearing date field and manage its required/readonly attributes
    // This function will now be driven by the *selectedStatus* from the dropdown
    const toggleNextHearingDateField = (selectedStatus) => {
        if (nextHearingDateGroup && nextHearingDateInput) {
            // The date field should be editable (visible, not readonly) ONLY if the selected status is 'Ongoing'
            if (selectedStatus === 'Ongoing') {
                nextHearingDateGroup.style.display = 'block'; // Make it visible
                nextHearingDateInput.setAttribute('required', 'required'); // Make it required
                nextHearingDateInput.removeAttribute('readonly'); // Make it editable
                nextHearingDateInput.classList.remove('read-only-field'); // Remove dark gray bg
                if (nextHearingDateLabel) {
                    nextHearingDateLabel.classList.remove('read-only'); // Remove label styling
                }
            } else {
                // For any other status, hide it, make it readonly, and apply dark gray bg
                nextHearingDateGroup.style.display = 'none'; // Hide it
                nextHearingDateInput.removeAttribute('required'); // Remove required
                nextHearingDateInput.setAttribute('readonly', 'readonly'); // Make it read-only
                nextHearingDateInput.classList.add('read-only-field'); // Add dark gray bg
                nextHearingDateInput.value = ''; // Clear the value when hidden or made readonly

                if (nextHearingDateLabel) {
                    nextHearingDateLabel.classList.add('read-only'); // Apply label styling
                }
            }
        }
    };

    // Event listener for opening the modal (when "Report Summary / Change Status" button is clicked)
    document.addEventListener('click', function(event) {
        const clickedButton = event.target.closest('.open-combined-action-modal');

        if (clickedButton && combinedActionModal && modalDocketInput && reportSummaryTextarea && actionSelection && modalSelectedStatusForSubmit) {
            const docket = clickedButton.getAttribute('data-docket');
            const originalHearingStatus = clickedButton.getAttribute('data-hearing'); // Get original status

            modalDocketInput.value = docket;
            reportSummaryTextarea.value = ''; // Clear summary text on open
            actionSelection.value = ''; // Reset status selection on open
            modalSelectedStatusForSubmit.value = ''; // Clear hidden status for submission

            // Pre-select 'Ongoing' if the original status was 'Rehearing'
            // This also implicitly triggers the toggleNextHearingDateField via the change event
            if (originalHearingStatus === 'Rehearing') {
                const ongoingOption = Array.from(actionSelection.options).find(opt => opt.value === 'Ongoing');
                if (ongoingOption) {
                    actionSelection.value = 'Ongoing';
                    modalSelectedStatusForSubmit.value = 'Ongoing';
                }
            }

            // Manually trigger the toggle based on the *initial* selection (or lack thereof)
            // if the modal opens without a default selection that would fire a 'change' event
            toggleNextHearingDateField(actionSelection.value);

            combinedActionModal.style.display = 'flex';
            console.log(`Opening Combined Action Modal for Docket: ${docket}, Original Status: ${originalHearingStatus}`);
        }
    });

    // --- IMPORTANT CHANGE: Event listener for the "Change Status To" dropdown within the modal ---
    if (actionSelection && modalSelectedStatusForSubmit) {
        actionSelection.addEventListener('change', function() {
            const selectedStatus = this.value;
            modalSelectedStatusForSubmit.value = selectedStatus; // Update the hidden input

            // Dynamically hide/show/make-readonly the date field based on the *newly selected* status
            toggleNextHearingDateField(selectedStatus);
            console.log(`Status changed to: ${selectedStatus}. Next Hearing Date field updated.`);
        });
    }


    // Event listener for clicking outside the modal
    if (combinedActionModal) {
        combinedActionModal.addEventListener('click', function(event) {
            if (event.target === combinedActionModal) {
                combinedActionModal.style.display = 'none';
                if (combinedActionForm) combinedActionForm.reset();
                // Reset date field to hidden/readonly state on close
                toggleNextHearingDateField('');
                console.log('Closing Combined Action Modal by clicking overlay.');
            }
        });
    }

    // Event listener for the "Cancel" button
    if (cancelCombinedBtn) {
        cancelCombinedBtn.addEventListener('click', () => {
            if (combinedActionModal) {
                combinedActionModal.style.display = 'none';
                if (combinedActionForm) combinedActionForm.reset();
                // Reset date field to hidden/readonly state on cancel
                toggleNextHearingDateField('');
                console.log('Closing Combined Action Modal via Cancel button.');
            }
        });
    }

    // Event listener for form submission
    if (combinedActionForm && modalSelectedStatusForSubmit && actionSelection) {
        combinedActionForm.addEventListener('submit', function(event) {
            const selectedStatus = actionSelection.value;
            const summaryText = reportSummaryTextarea.value;
            const nextHearingDateValue = nextHearingDateInput.value;
            const isNextHearingDateVisible = nextHearingDateGroup.style.display !== 'none';

            if (!selectedStatus) {
                alert('Please select a status option.');
                event.preventDefault();
                return;
            }
            if (!summaryText.trim()) {
                alert('Please enter the report summary.');
                event.preventDefault();
                return;
            }

            // Validation for Next Hearing Date if it's visible and required
            if (isNextHearingDateVisible && nextHearingDateInput.hasAttribute('required') && !nextHearingDateValue) {
                alert('Please enter the Next Hearing Date.');
                event.preventDefault();
                return;
            }

            modalSelectedStatusForSubmit.value = selectedStatus;

            console.log('Form Submit Data:');
            console.log('Docket:', modalDocketInput.value);
            console.log('Selected Status:', selectedStatus);
            console.log('Summary:', summaryText);
            if (isNextHearingDateVisible) {
                console.log('Next Hearing Date:', nextHearingDateValue);
            }
        });
    } else {
        console.warn('Combined action form elements not found for submission handling.');
    }
});