<?php
// backend/fd_controllers/residents.controller.php
session_start(); // Start the session at the very beginning

require_once __DIR__ . '/../config/database.config.php';
require_once __DIR__ . '/../models/residents.model.php';
require_once __DIR__ . '/../helpers/formatters.php'; // Ensure formatters.php is included for formatAddress, getAge

function sendJsonResponse($data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
    exit(); // Crucial: Stop script execution after sending JSON
}

$residentsModel = new Residents();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? ''; // Get the action first

    switch ($action) {
        case 'update_resident':
            if (isset($_POST['resident_id']) && !empty($_POST['resident_id'])) {
                $residentIdToUpdate = $_POST['resident_id'];

                $updateData = [
                    'first_name'    => $_POST['first_name'] ?? '',
                    'middle_name'   => $_POST['middle_name'] ?? '',
                    'last_name'     => $_POST['last_name'] ?? '',
                    'suffix'        => $_POST['suffix'] ?? '',
                    'birthday'      => $_POST['birthday'] ?? '',
                    'age'           => getAge($_POST['birthday'] ?? '') ?? '', // Recalculate age on update
                    'gender'        => $_POST['gender'] ?? '',
                    'civil_status'  => $_POST['civil_status'] ?? '',
                    'house_number'  => $_POST['house_number'] ?? '',
                    'street'        => $_POST['street'] ?? '',
                    'purok'         => $_POST['purok'] ?? '',
                    'barangay'      => $_POST['barangay'] ?? '',
                    'city'          => $_POST['city'] ?? '',
                    'email'         => $_POST['email'] ?? '',
                    'contact_number' => $_POST['contact_number'] ?? '',
                ];

                // Handle Photo Update for EXISTING Resident
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $file = $_FILES['photo'];
                    $uploadDir = __DIR__ . '/../../frontdesk/images/residents/'; // Absolute path for saving

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $uniqueFilename = uniqid('resident_', true) . '.' . $fileExtension;
                    $destinationPath = $uploadDir . $uniqueFilename;

                    // Optional: Delete old photo if it exists
                    $currentResident = $residentsModel->getResidentById($residentIdToUpdate); // This will fetch status
                    if ($currentResident && !empty($currentResident['photo_path'])) {
                        // The stored path is relative to the project root, so prepend project root for deletion
                        $oldPhotoPath = __DIR__ . '/../../' . $currentResident['photo_path'];
                        if (file_exists($oldPhotoPath) && is_file($oldPhotoPath)) {
                            unlink($oldPhotoPath);
                        }
                    }

                    if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
                        // Store the path relative to the project root in the database
                        $updateData['photo_path'] = 'frontdesk/images/residents/' . $uniqueFilename;
                    } else {
                        sendJsonResponse(['success' => false, 'message' => 'Failed to upload new photo.']);
                    }
                }

                if ($residentsModel->updateResident($residentIdToUpdate, $updateData)) {
                    sendJsonResponse(['success' => true, 'message' => 'Resident updated successfully.']);
                } else {
                    sendJsonResponse(['success' => false, 'message' => 'Failed to update resident data.']);
                }
            } else {
                sendJsonResponse(['success' => false, 'message' => 'Resident ID not provided for update.']);
            }
            break;

        case 'add_resident':
            if (isset($_POST['first_name']) && !empty($_POST['first_name'])) {
                $fd_Data = [
                    'first_name'    => $_POST['first_name'] ?? '',
                    'middle_name'   => $_POST['middle_name'] ?? '',
                    'last_name'     => $_POST['last_name'] ?? '',
                    'suffix'        => $_POST['suffix'] ?? '',
                    'birthday'      => $_POST['birthday'] ?? '',
                    'age'           => getAge($_POST['birthday'] ?? '') ?? '',
                    'gender'        => $_POST['gender'] ?? '',
                    'civil_status'  => $_POST['civil_status'] ?? '',
                    'house_number'  => $_POST['houseNumber'] ?? '',
                    'street'        => $_POST['street'] ?? '',
                    'purok'         => $_POST['purok'] ?? '',
                    'barangay'      => $_POST['barangay'] ?? '',
                    'city'          => $_POST['city'] ?? '',
                    'email'         => $_POST['email'] ?? '',
                    'contact_number' => $_POST['contact_number'] ?? '',
                    'photo_path'    => null
                ];

                // Handle Photo Upload for NEW Resident
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $file = $_FILES['photo'];
                    $uploadDir = __DIR__ . '/../../frontdesk/images/residents/'; // Absolute path for saving

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $uniqueFilename = uniqid('resident_', true) . '.' . $fileExtension;
                    $destinationPath = $uploadDir . $uniqueFilename;

                    if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
                        // Store the path relative to the project root in the database
                        $fd_Data['photo_path'] = 'frontdesk/images/residents/' . $uniqueFilename;
                    } else {
                        sendJsonResponse(['success' => false, 'message' => 'Failed to upload photo for new resident.']);
                    }
                }

                if ($residentsModel->addResident($fd_Data)) {
                    sendJsonResponse(['success' => true, 'message' => 'Resident added successfully!']);
                } else {
                    sendJsonResponse(['success' => false, 'message' => 'Failed to add resident.']);
                }
            } else {
                sendJsonResponse(['success' => false, 'message' => 'Missing data for new resident registration.']);
            }
            break;

        case 'ban_resident':
            $residentId = $_POST['resident_id'] ?? null;
            if ($residentId) {
                // Use 'is_banned' column, set to 1 for banned
                if ($residentsModel->updateResidentStatus($residentId, 1)) {
                    sendJsonResponse(['success' => true, 'message' => 'Resident successfully banned.']);
                } else {
                    sendJsonResponse(['success' => false, 'message' => 'Failed to ban resident. Database error.']);
                }
            } else {
                sendJsonResponse(['success' => false, 'message' => 'Resident ID not provided for ban action.']);
            }
            break;

        case 'unban_resident':
            $residentId = $_POST['resident_id'] ?? null;
            if ($residentId) {
                // Use 'is_banned' column, set to 0 for unbanned
                if ($residentsModel->updateResidentStatus($residentId, 0)) {
                    sendJsonResponse(['success' => true, 'message' => 'Resident successfully unbanned.']);
                } else {
                    sendJsonResponse(['success' => false, 'message' => 'Failed to unban resident. Database error.']);
                }
            } else {
                sendJsonResponse(['success' => false, 'message' => 'Resident ID not provided for unban action.']);
            }
            break;

        case 'search_residents':
            $searchInput = $_POST['residentSearchInput'] ?? '';
            $currentPage = isset($_POST['page']) ? (int)$_POST['page'] : 1;
            $itemsPerPage = 10;
            $offset = ($currentPage - 1) * $itemsPerPage;

            $totalResidents = $residentsModel->getTotalResidentsCount($searchInput);
            $totalPages = ceil($totalResidents / $itemsPerPage);
            $records = $residentsModel->getResidentsPaginated($itemsPerPage, $offset, $searchInput);

            $tableRowsHtml = '';
            if (empty($records)) {
                $numColumns = 8;
                $tableRowsHtml = '<tr><td colspan="' . $numColumns . '" style="text-align: center; padding: 20px;">No resident match found.</td></tr>';
            } else {
                foreach ($records as $row) {
                    $fullAddressForDisplay = '';
                    if (!empty($row['house_number'])) $fullAddressForDisplay .= htmlspecialchars($row['house_number']) . ', ';
                    if (!empty($row['street'])) $fullAddressForDisplay .= htmlspecialchars($row['street']) . ', ';
                    if (!empty($row['purok'])) $fullAddressForDisplay .= htmlspecialchars($row['purok']) . ', ';
                    if (!empty($row['barangay'])) $fullAddressForDisplay .= htmlspecialchars($row['barangay']) . ', ';
                    if (!empty($row['city'])) $fullAddressForDisplay .= htmlspecialchars($row['city']);
                    $fullAddressForDisplay = rtrim($fullAddressForDisplay, ', ');

                    // --- PHOTO PATH LOGIC ---
                    $photoSource = 'images/residents/dummy_resident_.png'; // Default path (relative to frontdesk/)

                    if (!empty($row['photo_path'])) {
                        $dbPhotoPath = htmlspecialchars($row['photo_path']);
                        if (strpos($dbPhotoPath, 'frontdesk/') === 0) {
                            $photoSource = substr($dbPhotoPath, strlen('frontdesk/'));
                        } else {
                            $photoSource = $dbPhotoPath;
                        }
                    }
                    // --- END PHOTO PATH LOGIC ---

                    $tableRowsHtml .= "
                    <tr>
                        <td>
                            <div class='table-thumbnail'>
                                <img src='" . $photoSource . "' alt='Resident Photo' class='resident-photo-thumb'>
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

            $paginationHtml = '<div class="table-pagination-controls">';
            if ($currentPage > 1) {
                $paginationHtml .= '<a href="?page=' . ($currentPage - 1) . '" class="page-link" data-page="' . ($currentPage - 1) . '">&laquo; Previous</a>';
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $currentPage) ? 'active' : '';
                $paginationHtml .= '<a href="?page=' . $i . '" class="page-link ' . $activeClass . '" data-page="' . $i . '">' . $i . '</a>';
            }
            if ($currentPage < $totalPages) {
                $paginationHtml .= '<a href="?page=' . ($currentPage + 1) . '" class="page-link" data-page="' . ($currentPage + 1) . '">Next &raquo;</a>';
            }
            $paginationHtml .= '</div>';

            sendJsonResponse([
                'tableRows' => $tableRowsHtml,
                'paginationLinks' => $paginationHtml
            ]);
            break;

        default:
            sendJsonResponse(['success' => false, 'message' => 'Unrecognized action or invalid request.']);
            break;
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['resident_id']) && !empty($_GET['resident_id'])) {
        $residentId = $_GET['resident_id'];
        // CORRECTED: Fetch 'is_banned' from the model
        $residentData = $residentsModel->getResidentById($residentId);
        if ($residentData) {
            // Adjust photo_path for GET requests if this data is used for modals etc.
            if (!empty($residentData['photo_path'])) {
                $dbPhotoPath = htmlspecialchars($residentData['photo_path']);
                if (strpos($dbPhotoPath, 'frontdesk/') === 0) {
                    $residentData['photo_path'] = substr($dbPhotoPath, strlen('frontdesk/'));
                } else {
                    $residentData['photo_path'] = $dbPhotoPath;
                }
            } else {
                $residentData['photo_path'] = 'images/residents/dummy_resident_.png';
            }
            // CORRECTED: Send 'is_banned' as 'is_banned'
            $residentData['is_banned'] = $residentData['is_banned'] ?? 0; // Default to 0 (active) if not set in DB

            sendJsonResponse(['success' => true, 'data' => $residentData]);
        } else {
            sendJsonResponse(['success' => false, 'message' => 'Resident not found.']);
        }
    } else {
        sendJsonResponse(['success' => false, 'message' => 'Invalid GET request or missing parameters.']);
    }
} else {
    sendJsonResponse(['success' => false, 'message' => 'Invalid request method.']);
}