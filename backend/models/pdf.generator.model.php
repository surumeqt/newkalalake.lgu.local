<?php
require_once __DIR__ . '/../lib/fpdf.php';

class PDFGenerator extends FPDF {
    private $data;

    public function __construct($data) {
        parent::__construct();
        $this->data = $data;
        $this->AliasNbPages();
    }

    function Header() {
        $imagePath = __DIR__ . '/../../app/images/header.png';
        if (file_exists($imagePath)) {
            $this->Image($imagePath, 7, 7, 190);
            $this->Ln(30);
        }
    }

    function Footer() {
        $this->SetY(-30);

        $footerPath = __DIR__ . '/../../app/images/footer.png';
        if (file_exists($footerPath)) {
            $this->Image($footerPath, 10, $this->GetY(), 190);
        }
    }

    public function generateCombinedNoticeAndSummonBlob($hearingType, $hearingDate) {
        $complainantName = $this->data['Complainant_Name'] ?? $this->data['complainant_name'] ?? 'N/A';
        $complainantAddress = $this->data['Complainant_Address'] ?? $this->data['complainant_address'] ?? 'N/A';
        $respondentName = $this->data['Respondent_Name'] ?? $this->data['respondent_name'] ?? 'N/A';
        $respondentAddress = $this->data['Respondent_Address'] ?? $this->data['respondent_address'] ?? 'N/A';
        $caseTitle = $this->data['Case_Title'] ?? $this->data['case_title'] ?? 'N/A';
        $docketNo = $this->data['Docket_Case_Number'] ?? $this->data['docket_case_number'] ?? 'N/A';

        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 50, 'NOTICE TO COMPLAINANT', 0, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->Ln(10);
        $this->MultiCell(0, 8,
            "To: " . $complainantName . "\n" .
            "Address: " . $complainantAddress . "\n\n" .
            "You are hereby notified that a hearing will be held regarding the following case:\n\n" .
            "Case Title: " . $caseTitle . "\n" .
            "Docket No.: " . $docketNo . "\n\n" .
            "Scheduled on: $hearingDate\n" .
            "Hearing Type: $hearingType\n\n" .
            "Please be present at the Barangay Hall on the scheduled date."
        );

        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 30, 'SUMMON TO RESPONDENT', 0, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->Ln(10);
        $this->MultiCell(0, 8,
            "To: " . $respondentName . "\n" .
            "Address: " . $respondentAddress . "\n\n" .
            "You are hereby summoned to appear before the Barangay Lupon to address the following case:\n\n" .
            "Case Title: " . $caseTitle . "\n" .
            "Docket No.: " . $docketNo . "\n\n" .
            "Scheduled on: $hearingDate\n" .
            "Hearing Type: $hearingType\n\n" .
            "Failure to appear may result in sanctions as provided by law."
        );

        return $this->Output('S');
    }

    public function GenerateSummaryBlob($hearingDate, $hearingType){
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 30, 'NOTICE TO COMPLAINANT', 0, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->Ln(10);
        $this->MultiCell(0, 8,
            "To: " . $this->data['Complainant_Name'] . "\n" .
            "Address: " . $this->data['Complainant_Address'] . "\n\n" .
            "You are hereby notified that a hearing will be held regarding the following case:\n\n" .
            "Case Title: " . $this->data['Case_Title'] . "\n" .
            "Docket No.: " . $this->data['Docket_Case_Number'] . "\n\n" .
            "Scheduled on: $hearingDate\n" .
            "Hearing Type: $hearingType\n\n" .
            "Please be present at the Barangay Hall on the scheduled date."
        );

        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 30, 'SUMMON TO RESPONDENT', 0, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->Ln(10);
        $this->MultiCell(0, 8,
            "To: " . $this->data['Respondent_Name'] . "\n" .
            "Address: " . $this->data['Respondent_Address'] . "\n\n" .
            "You are hereby summoned to appear before the Barangay Lupon to address the following case:\n\n" .
            "Case Title: " . $this->data['Case_Title'] . "\n" .
            "Docket No.: " . $this->data['Docket_Case_Number'] . "\n\n" .
            "Scheduled on: $hearingDate\n" .
            "Hearing Type: $hearingType\n\n" .
            "Failure to appear may result in sanctions as provided by law."
        );

        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 30, "SUMMARY FOR " . $hearingType, 0, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->Ln(10);
        $this->MultiCell(0, 8,
            "Complainant Name: " . $this->data['Complainant_Name'] . "\n" .
            "Address: " . $this->data['Complainant_Address'] . "\n\n" .
            "----------------AGAINST-----------------\n\n" .
            "Respondent Name: " . $this->data['Respondent_Name'] . "\n" .
            "Address: " . $this->data['Respondent_Address'] . "\n\n" .
            $this->data['report_summary_text'] . "\n\n" .
            "Case Title: " . $this->data['Case_Title'] . "\n" .
            "Docket No.: " . $this->data['Docket_Case_Number'] . "\n\n" .
            "Scheduled on: $hearingDate\n" .
            "Hearing Type: $hearingType"
        );

        return $this->Output('S');
    }
}
