<?php
// file: app/frontdesk/fd_dashboard.php
include '../../backend/config/database.config.php';
include '../../backend/helpers/redirects.php';

redirectIfNotLoggedIn(); // This checks if the user is logged in for this specific request.

// Initialize PDO connection for this script
$pdo = (new Connection())->connect();

// Get username from session for display
$user_username = $_SESSION['username'] ?? 'Guest'; // Use a default if not set for some reason

// --- Initialize dashboard variables to 0 BEFORE the try block ---
// This ensures number_format() always receives a number.
$totalResidents = 0;
$residentsToday = 0;
$totalCertificates = 0;
$certificatesToday = 0;
$activeRestrictions = 0;
$recentCertificates = [];
$recentResidents = [];
$dashboardError = false; // Flag to indicate if there was an error fetching dashboard data

// --- PHP Logic to Fetch Dashboard Data ---
try {
    // Ensure timezone is set for accurate CURDATE() if your server is not in Asia/Manila
    date_default_timezone_set('Asia/Manila');

    // 1. Total Number of Residents
    $stmt = $pdo->query("SELECT COUNT(*) AS total_residents FROM residents");
    $totalResidents = (int)$stmt->fetchColumn(); // Cast to int

    // 2. Residents Registered Today
    // Use prepared statement with parameter for CURDATE for consistency and safety
    $today_date = date('Y-m-d'); // Get today's date in YYYY-MM-DD format
    $stmt = $pdo->prepare("SELECT COUNT(*) AS residents_today FROM residents WHERE DATE(created_at) = :today_date");
    $stmt->bindParam(':today_date', $today_date);
    $stmt->execute();
    $residentsToday = (int)$stmt->fetchColumn();

    // 3. Total Certificates Issued
    $stmt = $pdo->query("SELECT COUNT(*) AS total_certificates FROM certificates");
    $totalCertificates = (int)$stmt->fetchColumn();

    // 4. Certificates Issued Today
    $stmt = $pdo->prepare("SELECT COUNT(*) AS certificates_today FROM certificates WHERE DATE(issued_at) = :today_date");
    $stmt->bindParam(':today_date', $today_date);
    $stmt->execute();
    $certificatesToday = (int)$stmt->fetchColumn();

    // 5. Number of Active Restrictions (Banned Residents)
    $stmt = $pdo->query("SELECT COUNT(DISTINCT resident_id) AS active_restrictions FROM resident_restrictions WHERE is_active = TRUE");
    $activeRestrictions = (int)$stmt->fetchColumn();

    // 6. Recently Issued Certificates (Last 5)
    $stmt = $pdo->query("
        SELECT
            c.certificate_type,
            c.issued_at,
            r.first_name,
            r.last_name,
            u.full_name AS printed_by_name
        FROM certificates c
        JOIN residents r ON c.resident_id = r.resident_id
        LEFT JOIN users u ON c.printed_by_user_id = u.user_id
        ORDER BY c.issued_at DESC
        LIMIT 5
    ");
    $recentCertificates = $stmt->fetchAll();

    // 7. Recently Registered Residents (Last 5)
    $stmt = $pdo->query("
        SELECT
            first_name,
            last_name,
            created_at,
            address
        FROM residents
        ORDER BY created_at DESC
        LIMIT 5
    ");
    $recentResidents = $stmt->fetchAll();
} catch (PDOException $e) {
    // This block is executed if ANY of the queries fail
    error_log("Dashboard Data Fetch Error: " . $e->getMessage());
    $dashboardError = true; // Set flag to show generic error message in HTML
    // IMPORTANT: Variables remain as their initial '0' or '[]' values,
    // which prevents the number_format error.
}
?>

<div class="dashboard-content">
    <div class="dashboard-header">
        <h2>Dashboard Overview</h2>
        <p>Welcome back, <span class="user-name"><?php echo htmlspecialchars($user_username); ?></span>! Here's a
            quick summary of activities in Brgy. New Kalalake.</p>
    </div>

    <div class="quick-actions">
        <div class="action-buttons">
            <button class="btn btn-primary" data-url="./fd_residents.php" data-load-content="true">Register New
                Resident</button>
            <button class="btn btn-secondary" data-url="./fd_certificate.php" data-load-content="true">Issue
                Certificate</button>
        </div>
    </div>

    <?php if ($dashboardError): ?>
    <p class='error-message'>Error loading dashboard data. Please try again later. (Details logged:
        <?php echo htmlspecialchars($e->getMessage()); ?>)</p>
    <?php endif; ?>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Residents</h3>
            <p class="stat-value"><?php echo number_format($totalResidents); ?></p>
            <span class="stat-description">Registered in the system</span>
        </div>
        <div class="stat-card">
            <h3>Residents Today</h3>
            <p class="stat-value"><?php echo number_format($residentsToday); ?></p>
            <span class="stat-description">New registrations today</span>
        </div>
        <div class="stat-card">
            <h3>Certificates Issued</h3>
            <p class="stat-value"><?php echo number_format($totalCertificates); ?></p>
            <span class="stat-description">Overall issued certificates</span>
        </div>
        <div class="stat-card">
            <h3>Certificates Today</h3>
            <p class="stat-value"><?php echo number_format($certificatesToday); ?></p>
            <span class="stat-description">Issued today</span>
        </div>
        <div class="stat-card stat-alert">
            <h3>Active Restrictions</h3>
            <p class="stat-value"><?php echo number_format($activeRestrictions); ?></p>
            <span class="stat-description">Residents with active bans/restrictions</span>
        </div>
    </div>

    <div class="recent-activity-section">
        <div class="recent-certificates">
            <h3>Recent Certificates Issued</h3>
            <?php if (!empty($recentCertificates)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Resident</th>
                        <th>Issued At</th>
                        <th>Printed By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentCertificates as $cert): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cert['certificate_type']); ?></td>
                        <td><?php echo htmlspecialchars($cert['first_name'] . ' ' . $cert['last_name']); ?></td>
                        <td><?php echo date('M d, Y h:i A', strtotime($cert['issued_at'])); ?></td>
                        <td><?php echo htmlspecialchars($cert['printed_by_name'] ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No certificates issued recently.</p>
            <?php endif; ?>
        </div>

        <div class="recent-residents">
            <h3>Recently Registered Residents</h3>
            <?php if (!empty($recentResidents)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentResidents as $res): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($res['first_name'] . ' ' . $res['last_name']); ?></td>
                        <td><?php htmlspecialchars($res['address']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($res['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No residents registered recently.</p>
            <?php endif; ?>
        </div>
    </div>
</div>