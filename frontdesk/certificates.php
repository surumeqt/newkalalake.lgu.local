<div class="certificates-content">
    <h1>Certificate Management</h1>

    <div class="certificates-layout">
        <!-- Left Column: Certificate Form -->
        <section class="certificate-form-section">
            <h2>Generate Certificate</h2>
            <form id="certificateForm">
                <div class="form-group">
                    <label for="certificateType">Select Certificate Type</label>
                    <select id="certificateType" required>
                        <option value="">-- Select a type --</option>
                        <option value="barangay_clearance">Barangay Clearance</option>
                        <option value="indigency">Certificate of Indigency</option>
                        <option value="residency">Certificate of Residency</option>
                        <option value="death_certificate">Death Certificate</option>
                    </select>
                </div>

                <!-- Dynamic Inputs Area -->
                <div id="certificateInputsArea" class="certificate-inputs-area">
                    <!-- Inputs will be dynamically loaded here based on selection -->
                    <p style="text-align: center; color: #6c757d;">Please select a certificate type to show required fields.</p>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="clearCertificateFormBtn">Clear Form</button>
                    <button type="submit" class="btn btn-primary" id="generateCertificateBtn">Generate Certificate</button>
                </div>
            </form>
        </section>

        <!-- Right Column: Certificate Records -->
        <section class="certificate-records-section">
            <h2>Certificate Records</h2>
            <div class="certificate-table-container">
                <table class="certificate-table" id="certificateTable">
                    <thead>
                        <tr>
                            <th>Cert. Type</th>
                            <th>Issued To</th>
                            <th>Date Issued</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Static Data (will be replaced by dynamic data from JS/PHP) -->
                        <tr>
                            <td>Barangay Clearance</td>
                            <td>Juan Dela Cruz</td>
                            <td>2024-07-30</td>
                            <td>
                                <button class="action-btn btn-view" data-id="cert1">View</button>
                                <button class="action-btn btn-delete" data-id="cert1">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Certificate of Indigency</td>
                            <td>Maria Clara</td>
                            <td>2024-07-28</td>
                            <td>
                                <button class="action-btn btn-view" data-id="cert2">View</button>
                                <button class="action-btn btn-delete" data-id="cert2">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Certificate of Residency</td>
                            <td>Crisostomo Ibarra</td>
                            <td>2024-07-25</td>
                            <td>
                                <button class="action-btn btn-view" data-id="cert3">View</button>
                                <button class="action-btn btn-delete" data-id="cert3">Delete</button>
                            </td>
                        </tr>
                        <!-- End Example Static Data -->
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>