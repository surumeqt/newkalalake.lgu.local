<?php

namespace backend\models;

use backend\lib\FPDF;

class pdfmodel extends FPDF {
    private $data;
    private $filename;
    public function __construct($data) {
        parent::__construct('P', 'mm', 'Letter');
        $this->data = $data;
        $this->filename = generatePdfFilename();
    }

    function Header() {
        $bgPath = __DIR__ . '/../../public/assets/img/pdfbglogo.png';
        if (file_exists($bgPath)) {
            $this->Image($bgPath, 25, 70, 160, 160);
        }

        $imagePath = __DIR__ . '/../../public/assets/img/header.png';
        if (file_exists($imagePath)) {
            $this->Image($imagePath, 8, 1, 200);
            $this->Ln(35);
        }
    }

    function Footer() {
        $this->SetY(-30);

        $footerPath = __DIR__ . '/../../public/assets/img/footer.png';
        if (file_exists($footerPath)) {
            $this->Image($footerPath, 10, $this->GetY(), 190);
        }
    }

    public function generateNoticeSummonFile(){
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        $fullPath = getPdfFullPath($this->filename);
        $this->Output('F', $fullPath);
        return $this->filename;
    }
    public function generateSummaryFile(){
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        $fullPath = getPdfFullPath($this->filename);
        $this->Output('F', $fullPath);
        return $this->filename;
    }
}