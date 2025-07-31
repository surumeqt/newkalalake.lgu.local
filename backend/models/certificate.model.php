<?php
require_once __DIR__ . '/../config/database.config.php';
require_once __DIR__ . '/./pdf.generator.model.php';
require_once __DIR__ . '/../helpers/formatters.php';

class CertificateModel {
    private $conn;

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->connect();
    }
    public function createCertificate($data) {
        $certTypeshii = $this->certificateType($data,$data['certificate_type']);

        // --- debugging here ---
        echo "<pre>";
        echo "IF YOURE SEEING THIS ERROR, REMOVE THE WHITESPACE BEFORE THE NAME\n";
        var_dump($data['resident_name']);
        echo "</pre>";
        // -------------------------

        $residentId = $this->findIdByFullName($data['resident_name']);

        $sql = "INSERT INTO certificates (
                    resident_id,
                    certificate_type,
                    fileBlob,
                    issued_by,
                    certificate_no
                ) VALUES (
                    ?, ?, ?, ?, ?
                )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $residentId,
            $data['certificate_type'],
            $certTypeshii,
            $data['issued_by'],
            generateRandomIds()
        ]);
    }
    private function certificateType($data, $type) {
        $pdfGen = new PDFGenerator($data);
        switch ($type) {
            case 'Certificate of Indigency':
                $pdfBlob = $pdfGen->generateIndigencyBlob();
                break;
            case 'Barangay Residency':
                $pdfBlob = $pdfGen->generateResidencyBlob();
                break;
            case 'Certificate of Non-Residency':
                $pdfBlob = $pdfGen->generateNonResidencyBlob();
                break;
            case 'Barangay Permit':
                $pdfBlob = $pdfGen->generatePermitBlob();
                break;
            case 'Barangay Endorsement':
                $pdfBlob = $pdfGen->generateEndorsementBlob();
                break;
            case 'Vehicle Clearance':
                $pdfBlob = $pdfGen->generateVClearanceBlob();
                break;
            case 'Certification for 1st time Job Seekers':
                $pdfBlob = $pdfGen->generateJobSeekerBlob();
                break;
            case 'Certification for Low Income':
                $pdfBlob = $pdfGen->generateLowIncomeBlob();
                break;
            case 'Oath of Undertaking':
                $pdfBlob = $pdfGen->generateOathofUndertakingBlob();
                break;
            case 'Barangay Clearance':
                $pdfBlob = $pdfGen->generateBarangayClearance();
                break;
            default:
                throw new Exception("Invalid certificate type");
        }
        return $pdfBlob;
    }
    private function findIdByFullName($residentName) {
        $query = "SELECT resident_id FROM residents 
            WHERE TRIM(CONCAT_WS(' ',
                first_name,
                NULLIF(TRIM(middle_name), ''),
                last_name,
                NULLIF(TRIM(suffix), '')
            )) = ?";

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$residentName])) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['resident_id'];
            }
        }
        return null;
    }
    public function residentIssuedCertificates($residentId){
        $query = "SELECT
                id,
                resident_id,
                certificate_type,
                purpose,
                created_at,
                issued_by
            FROM
                certificates
            WHERE
                resident_id = ?
            ORDER BY
                created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$residentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTotalCertificatesIssued() {
        $query = "SELECT COUNT(id) AS total_certificates FROM certificates";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_certificates'] ?? 0;
    }
    public function getCertificatesIssuedToday() {
        $today = date('Y-m-d');
        $query = "SELECT COUNT(id) AS certificates_today FROM certificates WHERE DATE(created_at) = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$today]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['certificates_today'] ?? 0;
    }
    public function getRecentCertificateActivities($limit = 7) {
        $query = "SELECT
                      c.created_at AS activity_date,
                      c.certificate_type,
                      CONCAT(r.first_name, ' ', r.last_name) AS resident_name
                  FROM
                      certificates c
                  JOIN
                      residents r ON c.resident_id = r.resident_id
                  ORDER BY
                      c.created_at DESC
                  LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}