<div class="upload-page-container">
    <form action="../backend/upload.controller.php" method="POST" enctype="multipart/form-data" class="upload-form-content">
        <h2 class="upload-form-title">Upload Document</h2>

        <!-- Docket ID Section -->
        <div class="upload-form-section">
            <div class="upload-form-group">
                <label for="upload_doket_id" class="upload-form-label">Docket ID</label>
                <input type="text" id="upload_doket_id" name="doket_id" placeholder="Enter Docket ID" required class="upload-form-input">
            </div>
        </div>
 
        <!-- Hearing Type & Status Section (Flexbox Layout) -->
        <div class="upload-form-section upload-form-section-flex">
            <div class="upload-form-group upload-flex-item">
                <label for="upload_hearing_type" class="upload-form-label">Hearing Type</label>
                <select id="upload_hearing_type" name="hearing_type" required class="upload-form-select">
                    <option value="">-- Select Hearing --</option>
                    <option value="1st Hearing">1st Hearing</option>
                    <option value="2nd Hearing">2nd Hearing</option>
                    <option value="3rd Hearing">3rd Hearing</option>
                    <option value="Rehearing">Rehearing</option>
                    <option value="Banned">Banned</option>
                </select>
            </div>
            <div class="upload-form-group upload-flex-item">
                <label for="upload_status_selection" class="upload-form-label">Hearing Status</label>
                <select id="upload_status_selection" name="Hearing_Status" required class="upload-form-select">
                    <option value="">-- Choose Status --</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Rehearing">Rehearing</option>
                    <option value="Dismissed">Dismissed</option>
                    <option value="Withdrawn">Withdrawn</option>
                    <option value="Settled">Settled</option>
                    <option value="CFA">CFA</option>
                </select>
            </div>
        </div>

        <!-- Case & Parties Details Section -->
        <div class="upload-form-section">
            <h3 class="upload-section-title">Case & Party Details</h3>
            <div class="upload-form-group">
                <label for="upload_case_title" class="upload-form-label">Case Title</label>
                <input type="text" id="upload_case_title" name="case_title" placeholder="Enter Case Title" required class="upload-form-input">
            </div>
            <div class="upload-form-group">
                <label for="upload_complainant_name" class="upload-form-label">Complainant Name</label>
                <input type="text" id="upload_complainant_name" name="complainant_name" placeholder="Enter Complainant Name" required class="upload-form-input">
            </div>
            <div class="upload-form-group">
                <label for="upload_complainant_address" class="upload-form-label">Complainant Address</label>
                <input type="text" id="upload_complainant_address" name="complainant_address" placeholder="Enter Complainant Address" required class="upload-form-input">
            </div>
            <div class="upload-form-group">
                <label for="upload_respondent_name" class="upload-form-label">Respondent Name</label>
                <input type="text" id="upload_respondent_name" name="respondent_name" placeholder="Enter Respondent Name" required class="upload-form-input">
            </div>
            <div class="upload-form-group">
                <label for="upload_respondent_address" class="upload-form-label">Respondent Address</label>
                <input type="text" id="upload_respondent_address" name="respondent_address" placeholder="Enter Respondent Address" required class="upload-form-input">
            </div>
            <div class="upload-form-group">
                <label for="upload_hearing_date" class="upload-form-label">Hearing Date</label>
                <input type="date" id="upload_hearing_date" name="hearing_date" required class="upload-form-input">
            </div>
        </div>

        <!-- Report Summary Textarea (Conditional Visibility) -->
        <div class="upload-form-section" id="upload-report-summary-group" style="display: none;">
            <h3 class="upload-section-title">Report Summary</h3>
            <div class="upload-form-group">
                <label for="upload_report_summary_text" class="upload-form-label">Summary Details</label>
                <textarea
                    id="upload_report_summary_text"
                    name="report_summary_text"
                    rows="5"
                    placeholder="Type the report summary here..."
                    class="upload-form-textarea"></textarea>
            </div>
        </div>

        <!-- File Upload Section -->
        <div class="upload-form-section">
            <h3 class="upload-section-title">Document Upload</h3>
            <div class="upload-form-group">
                <label for="upload_file_input" class="upload-form-label">Select Files</label>
                <input type="file" id="upload_file_input" name="file_upload[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple required class="upload-form-input-file">
                <p class="upload-text-sm upload-text-gray-500 mt-1">Select one or more PDF, DOC, DOCX, JPG, or PNG files.</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="upload-form-actions">
            <button type="submit" class="upload-submit-btn">Upload Document</button>
        </div>
        
    </form>
</div>
