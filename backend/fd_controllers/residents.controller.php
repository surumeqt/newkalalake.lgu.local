<?php
// backend/fd_controllers/residents.controller.php
session_start(); // Start the session at the very beginning

require_once __DIR__ . '/../config/database.config.php';
require_once __DIR__ . '/../models/residents.model.php';
require_once __DIR__ . '/../helpers/formatters.php'; // Ensure formatters.php is included for formatAddress, getAge

// Assuming you have session management and user authentication here
// if (!isset($_SESSION['user_id'])) {
//     // If you want to redirect unauthorized users even for POSTs
//     // header('Location: /path/to/login.php'); // Adjust path as needed
//     // exit();
// }

$residentsModel = new Residents();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Handle Resident Registration (Form Submission) ---
    // This part of the code expects a direct POST from a form, not an AJAX request for registration.
    if (isset($_POST['first_name']) && !empty($_POST['first_name']) && !isset($_POST['resident_id']) && !isset($_POST['residentSearchInput'])) {

        $houseNumber = $_POST['houseNumber'] ?? '';
        $street = $_POST['street'] ?? '';
        $purok = $_POST['purok'] ?? '';
        $barangay = $_POST['barangay'] ?? '';
        $city = $_POST['city'] ?? '';

        $fd_Data = [
            'first_name'    => $_POST['first_name'] ?? '',
            'middle_name'   => $_POST['middle_name'] ?? '',
            'last_name'     => $_POST['last_name'] ?? '',
            'suffix'        => $_POST['suffix'] ?? '',
            'birthday'      => $_POST['birthday'] ?? '',
            'age'           => getAge($_POST['birthday'] ?? '') ?? '',
            'gender'        => $_POST['gender'] ?? '',
            'civil_status'  => $_POST['civil_status'] ?? '',
            'house_number'  => $houseNumber,
            'street'        => $street,
            'purok'         => $purok,
            'barangay'      => $barangay,
            'city'          => $city,
            'email'         => $_POST['email'] ?? '',
            'contact_number' => $_POST['contact_number'] ?? '',
        ];

        if ($residentsModel->addResident($fd_Data)) {
            // Set success message in session
            $_SESSION['message_type'] = 'success';
            $_SESSION['message'] = 'Resident added successfully!';
        } else {
            // Set error message in session
            $_SESSION['message_type'] = 'error';
            $_SESSION['message'] = 'Failed to add resident. Please try again.';
        }
        // Redirect back to the residents list page
        header('Location: ../../frontdesk/fd_app.php');
        exit(); // Stop script execution after redirect
    }
    // --- Handle Live Search / Pagination AJAX requests ---
    // This block *still* needs to return JSON, so the header is set here.
    else if (isset($_POST['residentSearchInput']) || isset($_POST['page'])) {
        // Set content type to JSON ONLY for AJAX requests
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
                // Construct the full address for display from new columns
                $displayAddress = [];
                if (!empty($row['house_number'])) $displayAddress[] = htmlspecialchars($row['house_number']);
                if (!empty($row['street'])) $displayAddress[] = htmlspecialchars($row['street']);
                if (!empty($row['purok'])) $displayAddress[] = htmlspecialchars($row['purok']);
                if (!empty($row['barangay'])) $displayAddress[] = htmlspecialchars($row['barangay']);
                if (!empty($row['city'])) $displayAddress[] = htmlspecialchars($row['city']);
                $fullAddressForDisplay = implode(', ', array_filter($displayAddress)); // Use array_filter to remove empty parts

                // Determine photo source
                $photoSource = '../../assets/img/dummy_resident_' . htmlspecialchars($row['gender'] ?? 'male') . '.jpg';
                if (isset($row['photo']) && !empty($row['photo'])) {
                    $photoSource = htmlspecialchars($row['photo']);
                }

                $tableRowsHtml .= "
                <tr>
                    <td>
                        <div class='table-thumbnail'>
                            <img src='" . $photoSource . "' alt='Resident Photo' class='profile-photo-small'>
                        </div>
                    </td>
                    <td>" . htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['suffix']) . "</td>
                    <td>" . $fullAddressForDisplay . "</td>
                    <td>" . htmlspecialchars($row['gender']) . "</td>
                    <td>" . htmlspecialchars($row['birthday']) . "</td>
                    <td>Barangay Residency</td>
                    <td>" . htmlspecialchars($row['created_at']) . "</td>
                    <td>
                        <button class='btn btn-sm btn-primary issue-certificate-btn open-new-certificate-modal-btn'
                            data-resident-id='" . htmlspecialchars($row['resident_id']) . "'
                            data-resident-name='" . htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['suffix']) . "'>
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

        echo json_encode([
            'tableRows' => $tableRowsHtml,
            'paginationLinks' => $paginationHtml
        ]);
        exit();
    } else {
        // If it's a POST request but not an add or search/pagination request
        // Don't send JSON header unless explicitly needed for other POST types
        // For a general "invalid request," you might redirect or show an error page
        $_SESSION['message_type'] = 'error';
        $_SESSION['message'] = 'Invalid or incomplete form submission.';
        header('Location: ../../frontdesk/fd_residents.php');
        exit();
    }
} else {
    // If it's not a POST request (e.g., a direct GET to this controller)
    $_SESSION['message_type'] = 'error';
    $_SESSION['message'] = 'Invalid request method.';
    header('Location: ../../frontdesk/fd_residents.php');
    exit();
}