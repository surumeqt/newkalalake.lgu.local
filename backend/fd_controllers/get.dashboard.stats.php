<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../models/resident.model.php';
require_once __DIR__ . '/../models/certificate.model.php';
// Assuming database.php is included by the models' constructors.
// If not, you might need require_once __DIR__ . '/../config/database.php'; here.

try {
    $residentModel = new ResidentModel();
    $certificateModel = new CertificateModel();

    $totalResidents = $residentModel->getTotalResidents();
    $residentsRegisteredToday = $residentModel->getResidentsRegisteredToday();
    $genderDistribution = $residentModel->getGenderDistribution();
    $ageGroupDistribution = $residentModel->getAgeGroupDistribution();
    $recentResidentActivities = $residentModel->getRecentResidentActivities(5); // Fetch 5 recent resident activities

    $totalCertificatesIssued = $certificateModel->getTotalCertificatesIssued();
    $certificatesIssuedToday = $certificateModel->getCertificatesIssuedToday();
    $recentCertificateActivities = $certificateModel->getRecentCertificateActivities(5); // Fetch 5 recent certificate activities

    // Combine all activities, sort by date, and take the top N
    $allRecentActivities = array_merge(
        array_map(function($item) {
            $item['description'] = "Resident \"" . $item['resident_name'] . "\" " . $item['activity_type'] . ".";
            return $item;
        }, $recentResidentActivities),
        array_map(function($item) {
            $item['description'] = $item['certificate_type'] . " issued to \"" . $item['resident_name'] . "\".";
            return $item;
        }, $recentCertificateActivities)
    );

    // Sort combined activities by date (descending)
    usort($allRecentActivities, function($a, $b) {
        return strtotime($b['activity_date']) - strtotime($a['activity_date']);
    });

    // Take top 7 activities for display
    $recentActivities = array_slice($allRecentActivities, 0, 7);

    echo json_encode([
        'success' => true,
        'metrics' => [
            'total_residents' => $totalResidents,
            'residents_registered_today' => $residentsRegisteredToday,
            'total_certificates_issued' => $totalCertificatesIssued,
            'certificates_issued_today' => $certificatesIssuedToday,
        ],
        'demographics' => [
            'gender' => $genderDistribution,
            'age_groups' => $ageGroupDistribution,
        ],
        'recent_activities' => $recentActivities,
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error fetching dashboard data: ' . $e->getMessage()]);
    exit();
}
