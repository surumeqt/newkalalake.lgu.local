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
            default:
                throw new Exception("Invalid certificate type");
        }
        return $pdfBlob;
    }
    private function findIdByFullName($residentName) {
        $query = "SELECT resident_id FROM residents WHERE CONCAT(first_name, ' ', middle_name, ' ', last_name) = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute([$residentName])) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['resident_id'];
            }
        }
        return null;
    }
}