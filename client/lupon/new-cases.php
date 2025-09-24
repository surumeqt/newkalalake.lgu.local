<div class="new-cases-container">
    <h1>New Cases</h1>
    <p>This is the new cases page where to input all the cases details.</p>

    <div class="case-form-container">
        <form action="/submit-new-case" method="POST" class="new-case-form">

            <div class="form-section">
                <h2>Complainant Information</h2>
                <div class="form-group">
                    <label for="complainant-name">Full Name</label>
                    <input type="text" id="complainant-name" name="complainant_name" required>
                </div>
                <div class="form-group">
                    <label for="complainant-address">Address</label>
                    <input type="text" id="complainant-address" name="complainant_address" required>
                </div>
                <div class="form-group">
                    <label for="complainant-contact">Contact No.</label>
                    <input type="text" id="complainant-contact" name="complainant_contact">
                </div>
            </div>

            <div class="form-section">
                <h2>Respondent Information</h2>
                <div class="form-group">
                    <label for="respondent-name">Full Name</label>
                    <input type="text" id="respondent-name" name="respondent_name" required>
                </div>
                <div class="form-group">
                    <label for="respondent-address">Address</label>
                    <input type="text" id="respondent-address" name="respondent_address" required>
                </div>
                <div class="form-group">
                    <label for="respondent-contact">Contact No.</label>
                    <input type="text" id="respondent-contact" name="respondent_contact">
                </div>
            </div>

            <div class="form-section">
                <h2>Case Details</h2>
                <div class="form-group">
                    <label for="case-subject">Subject of Complaint</label>
                    <input type="text" id="case-subject" name="case_subject" required>
                </div>
                <div class="form-group">
                    <label for="case-details">Details of Complaint</label>
                    <textarea id="case-details" name="case_details" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="date-filed">Date Filed</label>
                    <input type="date" id="date-filed" name="date_filed" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">File New Case</button>
                <button type="reset" class="reset-btn">Reset Form</button>
            </div>
        </form>
    </div>
</div>