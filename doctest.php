<?php

include 'backend/lib/fpdf.php';

class pdfmodel extends FPDF {
    private $data;
    public function __construct($data) {
        parent::__construct('P', 'mm', 'Letter');
        $this->data = $data;
    }

    function Header() {
        $bgPath = __DIR__ . '/public/assets/img/pdfbglogo.png';
        if (file_exists($bgPath)) {
            $this->Image($bgPath, 25, 70, 160, 160);
        }

        $imagePath = __DIR__ . '/public/assets/img/header.png';
        if (file_exists($imagePath)) {
            $this->Image($imagePath, 8, 1, 200);
            $this->Ln(35);
        }
    }

    function Footer() {
        $this->SetY(-30);

        $footerPath = __DIR__ . '/public/assets/img/footer.png';
        if (file_exists($footerPath)) {
            $this->Image($footerPath, 10, $this->GetY(), 190);
        }
    }

    public function generateNoticeSummonFile(){
        $this->AddPage();
        $this->SetFont('Times', 'B', 16);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        return $this->Output('S');
    }
    public function generateSummaryFile(){
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        return $this->Output('S');
    }
}

header('Content-Type: application/pdf');

$data = [
    'case_number' => '123',
    'case_title' => 'Test Case',
    'complainant_name' => 'John Doe',
    'complainant_address' => '123 Main St',
    'respondent_name' => 'Jane Smith',
    'respondent_address' => '456 Oak Ave',
    'time' => '10:00 am'
];

$pdf = new pdfmodel($data);
echo $pdf->generateNoticeSummonFile();