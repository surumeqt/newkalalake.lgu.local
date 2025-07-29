<div class="certificate-container">
    <h1>Issue A Certificate</h1>
    <form action="../backend/fd_controllers/certificate.controller.php" method="POST" id="certificateForm">
        <div class="form-group">
            <label for="certificate-type">Certificate Type:</label>
            <select id="certificate-type" name="certificate_type" class="certificate-form-control" onchange="handleCertificateChange(this)">
                <option value="">-- Select Certificate Type --</option>
                <option value="Certificate of Indigency">Certificate of Indigency</option>
                <option value="Barangay Residency">Barangay Residency</option>
                <option value="Certificate of Non-Residency">Certificate of Non-Residency</option>
                <option value="Barangay Permit">Barangay Permit</option>
                <option value="Barangay Endorsement">Barangay Endorsement</option>
                <option value="Vehicle Clearance">Vehicle Clearance</option>
            </select>
        </div>

        <div id="certificate-indigency-inputs" class="certificate-input-section">
            <div class="form-group">
                <label for="resident-name">Name:</label>
                <input type="text" name="resident-name" class="resident-name" onblur="fillResidentData(this)">
            </div>
            <div class="form-group">
                <label for="resident-age">Age:</label>
                <input type="text" class="resident-age" name="resident-age">
            </div>
            <div class="form-group">
                <label for="resident-birthdate">Birthdate:</label>
                <input type="date" class="resident-birthdate" name="resident-birthdate">
            </div>
            <div class="form-group">
                <label for="resident-address">Address:</label>
                <input type="text" class="resident-address" name="resident-address">
            </div>
            <div class="form-group">
                <label for="purpose">Purpose:</label>
                <textarea name="purpose" rows="3"></textarea>
            </div>
            <button type="submit" class="issue-certificate-btn">Issue Indigency</button>
        </div>

        <div id="certificate-residency-inputs" class="certificate-input-section">
            <div class="form-group">
                <label for="resident-name">Name:</label>
                <input type="text" name="resident-name" class="resident-name" onblur="fillResidentData(this)">
            </div>
            <div class="form-group">
                <label for="resident-age">Age:</label>
                <input type="text" class="resident-age" name="resident-age">
            </div>
            <div class="form-group">
                <label for="resident-birthdate">Birthdate:</label>
                <input type="date" class="resident-birthdate" name="resident-birthdate">
            </div>
            <div class="form-group">
                <label for="resident-address">Address:</label>
                <input type="text" class="resident-address" name="resident-address">
            </div>
            <div class="form-group">
                <label for="purpose">Purpose:</label>
                <textarea name="purpose" rows="3"></textarea>
            </div>
            <button type="submit" class="issue-certificate-btn">Issue Residency</button>
        </div>

        <div id="certificate-nonresidency-inputs" class="certificate-input-section">
            <div class="form-group">
                <label for="resident-name">Name:</label>
                <input type="text" name="resident-name" class="resident-name" onblur="fillResidentData(this)">
            </div>
            <div class="form-group">
                <label for="resident-address">Address:</label>
                <input type="text" class="resident-address" name="resident-address">
            </div>
            <div class="form-group">
                <label for="purpose">Purpose:</label>
                <textarea name="purpose" rows="3"></textarea>
            </div>
            <button type="submit" class="issue-certificate-btn">Issue Non-Residency</button>
        </div>

        <div id="certificate-permit-inputs" class="certificate-input-section">
            <div class="form-group">
                <label for="resident-name">Name:</label>
                <input type="text" name="resident-name" class="resident-name">
            </div>
            <div class="form-group">
                <label for="purpose">Permission to ...</label>
                <textarea name="purpose" rows="3"></textarea>
            </div>
            <button type="submit" class="issue-certificate-btn">Issue Permit</button>
        </div>

        <div id="barangay-endorsement-inputs" class="certificate-input-section">
            <div class="form-group">
                <label for="resident-name">Name:</label>
                <input type="text" name="resident-name" class="resident-name" onblur="fillResidentData(this)">
            </div>
            <div class="form-group">
                <label for="resident-address">Address:</label>
                <input type="text" class="resident-address" name="resident-address">
            </div>
            <div class="form-group">
                <label for="resident-business-name">Business Name:</label>
                <input type="text" class="resident-business-name" name="resident-business-name">
            </div>
            <div class="form-group">
                <label for="resident-business-address">Business Address:</label>
                <input type="text" class="resident-business-address" name="resident-business-address">
            </div>
            <div class="form-group">
                <label for="purpose">Purpose:</label>
                <textarea name="purpose" rows="3"></textarea>
            </div>
            <button type="submit" class="issue-certificate-btn">Issue Endorsement</button>
        </div>

        <div id="vehicle-clearance-inputs" class="certificate-input-section">
            <div class="form-group">
                <label for="resident-name">Name:</label>
                <input type="text" name="resident-name" class="resident-name" onblur="fillResidentData(this)">
            </div>
            <div class="form-group">
                <label for="resident-age">Age:</label>
                <input type="text" class="resident-age" name="resident-age">
            </div>
            <div class="form-group">
                <label for="resident-address">Address:</label>
                <input type="text" class="resident-address" name="resident-address">
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Make</th>
                        <th>Color</th>
                        <th>Year Model</th>
                        <th>Plate Number</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="vehicle-type"></td>
                        <td><input type="text" name="vehicle-make"></td>
                        <td><input type="text" name="vehicle-color"></td>
                        <td><input type="text" name="vehicle-model"></td>
                        <td><input type="text" name="vehicle-plate"></td>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th>Body Number</th>
                        <th>CR Number</th>
                        <th>Motor Number</th>
                        <th>Chasis Number</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="vehicle-body-number"></td>
                        <td><input type="text" name="vehicle-cr-number"></td>
                        <td><input type="text" name="vehicle-motor-number"></td>
                        <td><input type="text" name="vehicle-chasis-number"></td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label for="purpose">Purpose:</label>
                <textarea name="purpose" rows="3"></textarea>
            </div>
            <button type="submit" class="issue-certificate-btn">Issue Vehicle Clearance</button>
        </div>
    </form>
</div>