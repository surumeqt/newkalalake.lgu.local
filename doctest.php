<?php

require_once 'backend/lib/fpdf.php';
require_once 'backend/helpers/formatters.php';

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

    public function generateNoticeFile(){
        $hearing1 = $this->data['hearing_type'][0] ?? '';
        $date1 = $this->data['hearing_date'][0] ?? '';
        $hearing2 = $this->data['hearing_type'][1] ?? '';
        $date2 = $this->data['hearing_date'][1] ?? '';
        $hearing3 = $this->data['hearing_type'][2] ?? '';
        $date3 = $this->data['hearing_date'][2] ?? '';

        $this->AddPage();
        $this->SetFont('Times', 'B', 16);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        $this->Ln(5);
        $this->SetFont('Times','B',11);
        $this->Cell(0,8,'NOTICE OF HEARING',0,1,'C');
        $this->SetFont('Times','',10);
        $this->Cell(0,6,'(MEDIATION PROCEEDINGS)',0,1,'C');

        $this->Ln(3);
        $this->SetFont('Times','B',11);
        $this->Cell(100, 8, $this->data['complainant_name'], 0, 0);
        $this->SetFont('Times','',11);
        $this->Cell(90, 8, "$hearing1 (mediation): $date1", 0, 1, 'R');
        $this->SetFont('Times','B',11);
        $this->Cell(100, 8, $this->data['complainant_address'], 0, 0);
        $this->SetFont('Times','',11);
        $this->Cell(90, 8, "$hearing2 (mediation): $date2", 0, 1, 'R');
        $this->Cell(100, 8, 'Complainant', 0, 0);
        $this->SetFont('Times','',11);
        $this->Cell(90, 8, "$hearing3 (mediation): $date3", 0, 1, 'R');

        $this->Ln(3);
        $this->Cell(0,8,'        - against -',0,1);

        $this->Ln(3);
        $this->SetFont('Times','B',11);
        $this->Cell(0,8,$this->data['respondent_name'],0,1);
        $this->Cell(0,8,$this->data['respondent_address'],0,1);
        $this->SetFont('Times','',11);
        $this->Cell(0,8,'Respondent',0,1);

        $this->Ln(5);
        $this->Write(5,"      You are hereby required to appear before on this ");
        $this->SetFont('Times','B',11);
        $this->Write(5, formatHearingDate($this->data['hearing_date'][0]));
        $this->SetFont('Times','',11);
        $this->Write(5, " at ");
        $this->SetFont('Times','B',11);
        $this->Write(5, formatHearingTime($this->data['hearing_time']));
        $this->SetFont('Times','',11);
        $this->Write(5, " for the hearing of the above-entitled case of your complaint.");

        $this->Ln(15);
        $this->SetFont('Times','BU',11);
        $this->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
        $this->SetFont('Times','',10);
        $this->Cell(185,6,'Lupon Chairman',0,1,'R');

        $this->Ln(10);
        $this->Cell(40,8,'Received By: ____________________',0,1);
        $this->Cell(58,8,'Complainant\'s Name',0,1, 'R');

        $this->Ln(3);
        $this->Cell(40,8,'Date: ____________________________',0,1);
        $this->Cell(0,8,'Notified this _______ day of ________, 20__.',0,1);
        $this->Cell(0,8,'Served By: _________________________',0,1);
        $this->Cell(0,8,'Signature: __________________________',0,1);
    }
    public function generateSummonFile(){
        $hearing1 = $this->data['hearing_type'][0] ?? '';
        $date1 = $this->data['hearing_date'][0] ?? '';
        $hearing2 = $this->data['hearing_type'][1] ?? '';
        $date2 = $this->data['hearing_date'][1] ?? '';
        $hearing3 = $this->data['hearing_type'][2] ?? '';
        $date3 = $this->data['hearing_date'][2] ?? '';
        
        //Summons PDF
        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $this->data['complainant_name'], 0, 0);
        $this->Cell(90, 8, 'Barangay Case Number. '.$this->data['case_number'], 0, 1, 'R');
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $this->data['complainant_address'], 0, 0);
        $this->Cell(90, 8, 'FOR: '.$this->data['case_title'], 0, 1, 'R');
        $this->SetFont('Arial','',11);
        $this->Cell(100, 8, 'Complainant', 0, 1);
        
        $this->Ln(3);
        $this->Cell(0,8,'        - against -',0,1);

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $this->data['respondent_name'], 0, 0);
        $this->SetFont('Arial','',11);
        $this->Cell(90, 8, "$hearing1 (mediation): $date1", 0, 1, 'R');
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $this->data['respondent_address'], 0, 0);
        $this->SetFont('Arial','',11);
        $this->Cell(90, 8, "$hearing2 (mediation): $date2", 0, 1, 'R');
        $this->Cell(100, 8, 'Respondent', 0, 0);
        $this->SetFont('Arial','',11);
        $this->Cell(90, 8, "$hearing3 (mediation): $date3", 0, 1, 'R');

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,'SUMMONS MEDIATION',0,1,'C');

        $this->Ln(3);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,'TO: '.$this->data['respondent_name'],0,1);
        $this->SetFont('Arial','',11);
        $this->Cell(0,8,'Respondent',0,1);
        $this->Write(5,"      You are hereby summoned to appear before me in person, together with your witnesses, on the ");
        $this->SetFont('Times','B',11);
        $this->Write(5, formatHearingDate($this->data['hearing_date'][0]));
        $this->SetFont('Times','',11);
        $this->Write(5, " at ");
        $this->SetFont('Times','B',11);
        $this->Write(5, formatHearingTime($this->data['hearing_time']));
        $this->SetFont('Times','',11);
        $this->Write(5,', then and there to answer to a complaint made before me for mediation of your dispute with the complainant/s.');
        
        $this->Ln(15);
        $this->Write(5,"      You are hereby warned that if you refuse or willfully fail to appear in obedience to this summons, you may be barred from filing any counterclaim arising from said complaint.");

        $this->Ln(15);
        $this->Write(5, 'FAIL NOT or else face punishment as for indirect contempt of court.');

        $this->Ln(15);
        $this->SetFont('Arial','BU',11);
        $this->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
        $this->SetFont('Arial','',10);
        $this->Cell(185,6,'Lupon Chairman',0,1,'R');
    }
    public function generateSummaryFile(){
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');
    }
    public function getAllFiles(){
        $this->generateNoticeFile();
        $this->generateSummonFile();
        $this->generateSummaryFile();

        return $this->Output('I');
    }
}

header('Content-Type: application/pdf');

$data = [
    'case_number' => 'NK-01-01-25',
    'hearing_type' => ['1st Hearing', '2nd Hearing', '3rd Hearing'],
    'case_title' => 'KINAGAT/INAPI',
    'complainant_name' => 'MARK ALEXIS GAPUL',
    'complainant_address' => '123 Main St. New Kalalake, Olongapo City',
    'respondent_name' => 'KEVIN DULAY',
    'respondent_address' => '456 Oak Ave, Mulave st. New Kalalake, Olongapo City',
    'hearing_time' => '10:00',
    'hearing_date' => ['2025-01-01', '2025-01-02', '2025-01-03']
];

$pdf = new pdfmodel($data);
$pdf->getAllFiles();