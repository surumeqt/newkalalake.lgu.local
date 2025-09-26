<?php

namespace backend\models;

use FPDF;

class pdfmodel extends FPDF {
    private $data;
    private $filename;
    public function __construct($data) {
        parent::__construct();
        $this->data = $data;
        $this->filename = generatePdfFilename();
    }

    public function firsthearing(){
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        $fullPath = getPdfFullPath($this->filename);
        $this->Output('F', $fullPath);
        return $this->filename;
    }
}