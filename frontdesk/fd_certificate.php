<div class="certificate-container">
    <h1>Issue A Certificate</h1>
    <form action="" id="certificateForm"> 
        <div class="form-group"> 
            <label for="certificate-type">Certificate Type:</label>
            <select id="certificate-type" name="certificate_type" class="certificate-form-control">
                <option value="">-- Select Certificate Type --</option>
                <option value="Certificate of Indigency">Certificate of Indigency</option>
                <option value="Barangay Residency">Barangay Residency</option>
                <option value="Certificate of Non-Residency">Certificate of Non-Residency</option>
                <option value="Barangay Permit">Barangay Permit</option>
                <option value="Barangay Endorsement">Barangay Endorsement</option>
                <option value="Vehicle Clearance">Vehicle Clearance</option>
            </select>
        </div>

        <div id="barangay-endorsement-inputs" class="certificate-input-section hidden">
            <div class="form-group">
                <label for="endorsement-name">Name:</label>
                <input type="text" id="endorsement-name" name="endorsement_name" class="certificate-form-control" required>
            </div>
            <div class="form-group">
                <label for="endorsement-address">Address:</label>
                <input type="text" id="endorsement-address" name="endorsement_address" class="certificate-form-control" required>
            </div>
            <div class="form-group">
                <label for="endorsement-business-name">Business Name:</label>
                <input type="text" id="endorsement-business-name" name="endorsement_business_name" class="certificate-form-control">
            </div>
            <div class="form-group">
                <label for="endorsement-business-address">Business Address:</label>
                <input type="text" id="endorsement-business-address" name="endorsement_business_address" class="certificate-form-control">
            </div>
            <div class="form-group">
                <label for="endorsement-purpose">Purpose:</label>
                <textarea id="endorsement-purpose" name="endorsement_purpose" class="certificate-form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="issue-certificate-btn">Issue Endorsement</button>
        </div>
    </form>
</div>