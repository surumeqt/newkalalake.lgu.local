<?php
require_once __DIR__ . '/../lib/fpdf.php';

class PDFGenerator extends FPDF {
    private $data;

    public function __construct($data) {
        parent::__construct();
        $this->data = $data;
    }
    public function generateCombinedNoticeAndSummonBlob($hearingType, $hearingDate) {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'NOTICE TO COMPLAINANT', 0, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->Ln(10);
        $this->MultiCell(0, 8,
            "To: " . $this->data['complainant_name'] . "\n" .
            "Address: " . $this->data['complainant_address'] . "\n\n" .
            "You are hereby notified that a hearing will be held regarding the following case:\n\n" .
            "Case Title: " . $this->data['case_title'] . "\n" .
            "Docket No.: " . $this->data['docket_case_number'] . "\n\n" .
            "Scheduled on: $hearingDate\n" .
            "Hearing Type: $hearingType\n\n" .
            "Please be present at the Barangay Hall on the scheduled date."
        );

        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'SUMMON TO RESPONDENT', 0, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->Ln(10);
        $this->MultiCell(0, 8,
            "To: " . $this->data['respondent_name'] . "\n" .
            "Address: " . $this->data['respondent_address'] . "\n\n" .
            "You are hereby summoned to appear before the Barangay Lupon to address the following case:\n\n" .
            "Case Title: " . $this->data['case_title'] . "\n" .
            "Docket No.: " . $this->data['docket_case_number'] . "\n\n" .
            "Scheduled on: $hearingDate\n" .
            "Hearing Type: $hearingType\n\n" .
            "Failure to appear may result in sanctions as provided by law."
        );

        return $this->Output('S');
    }
}
