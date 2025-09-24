<div class="upload-cases-container">
    <h1>Upload Old Cases</h1>
    <p>This is where to upload old cases or add photos to existing cases using case number.</p>

    <div class="case-form-container">
        <form action="/submit-new-case" method="POST" class="new-case-form">

            <div class="form-section">
                <h2>Case Information</h2>
                <div class="form-group">
                    <label for="case-number">Case Number</label>
                    <input type="text" id="case-number" name="case_number" required>
                </div>
                <div class="form-group">
                    <label for="case-title">Case Title</label>
                    <input type="text" id="case-title" name="case_title" required>
                </div>
                <div class="form-group">
                    <label for="case-nature">Nature of Case</label>
                    <input type="text" id="case-nature" name="case_nature" required>
                </div>
            </div>

            <div class="person-info-group">
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
            </div>

            <div class="form-section">
                <h2>Hearing Details</h2>
                <div class="form-group">
                    <label for="time-filed">Time of Hearing (1st Hearing)</label>
                    <input type="time" id="time-filed" name="time_filed" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">File Old Case</button>
                <button type="reset" class="reset-btn">Reset Form</button>
            </div>
        </form>
    </div>
</div>