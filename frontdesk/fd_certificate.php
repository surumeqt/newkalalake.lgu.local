<div class="certificate-page-container">
    <?php if (isset($_GET['certificate_issued'])): ?>
        <div class="alert 
        <?= $_GET['certificate_issued'] === 'success' ? 'alert-success' : 'alert-error' ?>">
            <?= $_GET['certificate_issued'] === 'success' ? 'Certificate issued successfully!' : 'An error occurred while issuing the certificate.' ?>
        </div>
        <script>
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) alert.style.display = 'none';
            }, 3000); // Hide after 3 seconds
        </script>
    <?php endif; ?>

    <div class="certificate-container">
        <h1>Issue A Certificate</h1>
        <form action="../backend/fd_controllers/certificate.controller.php" method="POST" id="certificateForm">
            <div class="form-group">
                <label for="certificate-type">Certificate Type:</label>
                <select id="certificate-type" name="certificate_type" class="certificate-form-control"
                    onchange="handleCertificateChange(this)">
                    <option value="">-- Select Certificate Type --</option>
                    <option value="Barangay Permit">Barangay Permit</option>
                    <option value="Barangay Clearance">Barangay Clearance</option>
                    <option value="Barangay Endorsement">Barangay Endorsement</option>
                    <option value="Barangay Residency">Barangay Residency</option>
                    <option value="Certificate of Indigency">Certificate of Indigency</option>
                    <option value="Certificate of Non-Residency">Certificate of Non-Residency</option>
                    <option value="Certification for 1st time Job Seekers">Certification for 1st time Job Seekers
                    </option>
                    <option value="Certification for Low Income">Certification for Low Income</option>
                    <option value="Oath of Undertaking">Oath of Undertaking</option>
                    <option value="Vehicle Clearance">Vehicle Clearance</option>
                </select>
            </div>
            <!-- Placeholder for "Select a Certificate" -->
            <div id="" class="certificate-hidden">
                <div id="select-certificate-placeholder" class="select-certificate-placeholder">
                    Select a Certificate Type to see the form fields.
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

                <div id="certificate-clearance-inputs" class="certificate-input-section">
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
                    <button type="submit" class="issue-certificate-btn">Issue Clearance</button>
                </div>

                <div id="certificate-js-inputs" class="certificate-input-section">
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
                    <button type="submit" class="issue-certificate-btn">Issue Certificate</button>
                </div>

                <div id="certificate-oath-inputs" class="certificate-input-section">
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
                    <button type="submit" class="issue-certificate-btn">Issue Oath of Undertaking</button>
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

                <div id="certificate-lowIncome-inputs" class="certificate-input-section">
                    <div class="form-group">
                        <label for="resident-name">Name:</label>
                        <input type="text" name="resident-name" class="resident-name" onblur="fillResidentData(this)">
                    </div>
                    <div class="form-group">
                        <label for="resident-address">Address:</label>
                        <input type="text" class="resident-address" name="resident-address">
                    </div>
                    <div class="form-group">
                        <label for="resident-monthly-salary">Monthly Income:</label>
                        <input type="number" id="resident-monthly-salary" name="resident-monthly-salary"
                            class="resident-monthly-salary">
                    </div>
                    <div class="form-group">
                        <label for="resident-occupation">Occupation:</label>
                        <input type="text" id="resident-occupation" name="resident-occupation"
                            class="resident-occupation">
                    </div>
                    <button type="submit" class="issue-certificate-btn">Issue Low Income Certification</button>
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
            </div>
            <input type="hidden" name="issued-by" value="<?= $_SESSION['username'] ?>">
        </form>
    </div>
    <!-- History Records Section -->
    <div class="records-container">
        <h1 class="">
            History Records
        </h1>
        <div class="table-container">
            <table class="">
                <thead class="">
                    <tr>
                        <th class="">Resident ID</th>
                        <th class="">Resident Name</th>
                        <th class="">Certificate Type</th>
                        <th class="">Issued By</th>
                        <th class="actions-th">Actions</th>
                    </tr>
                </thead>
                <?php
                require_once __DIR__ . '/../backend/models/certificate.model.php';

                $certificateModel = new CertificateModel();

                $records = $certificateModel->listCertificate();
                ?>
                <tbody id="records-table-body">
                    <?php foreach (array_slice($records, 0, 5) as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['resident_id']) ?></td>
                            <td><?= htmlspecialchars($row['first_name'] . (!empty($row['middle_name']) ? ' ' . $row['middle_name'] : '') . ' ' . $row['last_name']) . (!empty($row['suffix']) ? ' ' . $row['suffix'] : '') ?>
                            </td>
                            <td><?= htmlspecialchars($row['certificate_type']) ?></td>
                            <td><?= htmlspecialchars($row['issued_by']) ?></td>
                            <td class="actions-btn">
                                <button class="action-button view">
                                    <a href="../backend/fd_controllers/view.certificate.php?id=<?= $row['id'] ?>"
                                        target="_blank">
                                        View
                                    </a>
                                </button>
                                <button class="action-button delete"
                                    onclick="deleteResident('<?php echo $row['resident_id']; ?>')">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>