<?php

require_once __DIR__ . '/../models/residents.model.php';
require_once __DIR__ . '/../helpers/formatters.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $residentsModel = new Residents();

    // --- Handle Resident Registration (existing logic, remains unchanged) ---
    if (isset($_POST['first_name']) && !empty($_POST['first_name']) && !isset($_POST['residentSearchInput'])) {
        $address = formatAddress([
            'houseNumber' => $_POST['houseNumber'] ?? '',
            'street' => $_POST['street'] ?? '',
            'purok' => $_POST['purok'] ?? '',
            'barangay' => $_POST['barangay'] ?? '',
            'city' => $_POST['city'] ?? ''
        ]);
        $fd_Data = [
            'first_name'    => $_POST['first_name'] ?? '',
            'middle_name'   => $_POST['middle_name'] ?? '',
            'last_name'     => $_POST['last_name'] ?? '',
            'suffix'        => $_POST['suffix'] ?? '',
            'birthday'      => $_POST['birthday'] ?? '',
            'age'           => getAge($_POST['birthday'] ?? '') ?? '',
            'gender'        => $_POST['gender'] ?? '',
            'civil_status'  => $_POST['civil_status'] ?? '',
            'address'       => $address ?? '',
            'email'         => $_POST['email'] ?? '',
            'contact_number' => $_POST['contact_number'] ?? '',
        ];

        $residentsModel->addResident($fd_Data);
        header('Location: ../../frontdesk/fd_app.php?success=Resident added successfully');
        exit();
    }

    // --- Handle Live Search / Pagination AJAX requests ---
    // Check if the request includes search input or a page number (indicating an AJAX request for data)
    if (isset($_POST['residentSearchInput']) || isset($_POST['page'])) {
        // Set content type to JSON
        header('Content-Type: application/json');

        $searchInput = $_POST['residentSearchInput'] ?? '';
        $currentPage = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $itemsPerPage = 20; // Must match the value in frontdesk/fd_residents.php
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch total count and paginated records using the model methods
        $totalResidents = $residentsModel->getTotalResidentsCount($searchInput);
        $totalPages = ceil($totalResidents / $itemsPerPage);
        $records = $residentsModel->getResidentsPaginated($itemsPerPage, $offset, $searchInput);

        // Build the HTML for table rows
        $tableRowsHtml = '';
        if (empty($records)) {
            $numColumns = 8; // Adjust this if your table columns change
            $tableRowsHtml = '<tr><td colspan="' . $numColumns . '" style="text-align: center; padding: 20px;">No resident match found.</td></tr>';
        } else {
            foreach ($records as $row) {
                // Ensure $row is used, not $rows (as fixed in previous turns)
                $tableRowsHtml .= "
                <tr>
                    <td>
                        <div class='table-thumbnail'>
                            <i class='fas fa-user-circle default-thumbnail'></i>
                        </div>
                    </td>
                    <td>" . htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['suffix'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['address']) . "</td>
                    <td>" . htmlspecialchars($row['gender']) . "</td>
                    <td>" . htmlspecialchars($row['birthday']) . "</td>
                    <td>Barangay Residency</td>
                    <td>" . htmlspecialchars($row['created_at']) . "</td>

                    <td>
                        <button class='btn btn-sm btn-primary issue-certificate-btn open-new-certificate-modal-btn'
                            data-resident-id='" . htmlspecialchars($row['resident_id']) . "'
                            data-resident-name='" . htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['suffix'] ?? '') . "'>
                            <i class='fas fa-file-alt'></i> Issue
                        </button>
                        <button class='btn btn-sm btn-info view-resident-btn' data-url='./fd_resident_profile.php'
                            data-load-content='true' data-resident-id='" . htmlspecialchars($row['resident_id']) . "'><i
                                class='fas fa-eye'></i> View
                        </button>
                    </td>
                </tr>";
            }
        }

        // Build the HTML for pagination links
        $paginationHtml = '';
        if ($totalPages > 1) {
            if ($currentPage > 1) {
                // Use data-page attribute for JavaScript to pick up the page number
                $paginationHtml .= '<a href="#" class="page-link" data-page="' . ($currentPage - 1) . '">&laquo; Previous</a>';
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $currentPage) ? 'active' : '';
                $paginationHtml .= '<a href="#" class="page-link ' . $activeClass . '" data-page="' . $i . '">' . $i . '</a>';
            }
            if ($currentPage < $totalPages) {
                $paginationHtml .= '<a href="#" class="page-link" data-page="' . ($currentPage + 1) . '">Next &raquo;</a>';
            }
        }

        // Encode and send both HTML parts as a JSON response
        echo json_encode([
            'tableRows' => $tableRowsHtml,
            'paginationLinks' => $paginationHtml
        ]);
        exit(); // Stop further script execution
    }
}