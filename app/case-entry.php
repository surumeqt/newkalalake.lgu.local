<div class="container-entry-case">
    <form action="../backend/case.controller.php" method="POST" class="lupon-form-content">
        <h2 class="form-title">Lupon Case Entry Form</h2>

        <!-- Header Section -->
        <div class="form-section">
            <div class="form-group">
                <label for="docket_case_number">Docket Case Number</label>
                <input type="text" id="docket_case_number" name="docket_case_number" required placeholder="Enter Docket Case Number" class="form-input">
            </div>
            <div class="form-group">
                <label for="case_title">Case Title</label>
                <input type="text" id="case_title" name="case_title" required placeholder="Enter Case Title" class="form-input">
            </div>
        </div>

        <!-- Complainant Section -->
        <div class="form-section">
            <h3 class="section-title">Complainant Details</h3>
            <div class="form-group">
                <label for="complainant_name">Complainant Name</label>
                <input type="text" id="complainant_name" name="complainant_name" required placeholder="Enter Complainant Name" class="form-input">
            </div>
            <div class="form-group">
                <label for="complainant_address">Complainant Address</label>
                <input type="text" id="complainant_address" name="complainant_address" required placeholder="Enter Complainant Address" class="form-input">
            </div>
        </div>

        <!-- Respondent Section -->
        <div class="form-section">
            <h3 class="section-title">Respondent Details</h3>
            <div class="form-group">
                <label for="respondent_name">Respondent Name</label>
                <input type="text" id="respondent_name" name="respondent_name" required placeholder="Enter Respondent Name" class="form-input">
            </div>
            <div class="form-group">
                <label for="respondent_address">Respondent Address</label>
                <input type="text" id="respondent_address" name="respondent_address" required placeholder="Enter Respondent Address" class="form-input">
            </div>
        </div>

        <!-- Hearing Section -->
        <div class="form-section">
            <h3 class="section-title">Hearing Details</h3>
            <div class="form-group">
                <label for="hearing_type">Hearing Type</label>
                <select id="hearing_type" name="hearing_type" required class="form-select">
                    <option value="">-- Select Hearing --</option>
                    <option value="1st Hearing">1st Hearing</option>
                </select>
            </div>
            <div class="form-group">
                <label for="case_type">Case Type</label>
                <select id="case_type" name="case_type" required class="form-select">
                    <option value="">-- Select Case Type --</option>
                    <option value="criminal">Criminal Case</option>
                    <option value="civil">Civil Case</option>
                </select>
            </div>
            <div class="form-group">
                <label for="time">Time of Hearing (ex. 10:00 AM)</label>
                <div class="form-relative">
                    <input type="text" placeholder="Enter Time of Hearing" id="hours" name="hours" required class="form-input">
                    <select id="iat" name="iat" required class="form-relative-select">
                        <option value="">-- Select Time Class --</option>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="hearing_date">Hearing Date</label>
                <input type="date" id="hearing_date" name="hearing_date" required class="form-input">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-actions">
            <button type="submit" class="submit-btn">
                Submit Case
            </button>
        </div>
    </form>
</div>