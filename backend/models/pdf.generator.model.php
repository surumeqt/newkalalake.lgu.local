<?php
require_once __DIR__ . '/../lib/fpdf.php';
require_once __DIR__ . '/../helpers/formatters.php';

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

    public function generateCombinedNoticeAndSummonBlob($hearingTypes, $hearingDates, $hearingType, $hearingDate, $hearingTime, $timePeriod) {
        $complainantName = $this->data['Complainant_Name'] ?? $this->data['complainant_name'] ?? 'N/A';
        $complainantAddress = $this->data['Complainant_Address'] ?? $this->data['complainant_address'] ?? 'N/A';
        $respondentName = $this->data['Respondent_Name'] ?? $this->data['respondent_name'] ?? 'N/A';
        $respondentAddress = $this->data['Respondent_Address'] ?? $this->data['respondent_address'] ?? 'N/A';
        $caseTitle = $this->data['Case_Title'] ?? $this->data['case_title'] ?? 'N/A';
        $docketNo = $this->data['Docket_Case_Number'] ?? $this->data['docket_case_number'] ?? 'N/A';
        $formattedDate = formatHearingDate($hearingDate);
        $formattedTime = "at {$hearingTime} o'clock in the " . ($timePeriod === 'AM' ? 'morning' : 'afternoon');

        // Notice of Hearing PDF
        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,'NOTICE OF HEARING',0,1,'C');
        $this->SetFont('Arial','',10);
        $this->Cell(0,6,'(MEDIATION PROCEEDINGS)',0,1,'C');

        $this->Ln(3);
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $complainantName, 0, 0);
        $this->SetFont('Arial','',11);
        $hearing1 = $hearingTypes[0] ?? '1st Hearing';
        $date1 = $hearingDates[0] ?? '';
        $this->Cell(90, 8, "$hearing1 (mediation): $date1", 0, 1, 'R');
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $complainantAddress, 0, 0);
        $this->SetFont('Arial','',11);
        $hearing2 = $hearingTypes[1] ?? '2nd Hearing';
        $date2 = $hearingDates[1] ?? '';
        $this->Cell(90, 8, "$hearing2 (mediation): $date2", 0, 1, 'R');
        $this->Cell(100, 8, 'Complainant', 0, 0);
        $this->SetFont('Arial','',11);
        $hearing3 = $hearingTypes[2] ?? '3rd Hearing';
        $date3 = $hearingDates[2] ?? '';
        $this->Cell(90, 8, "$hearing3 (mediation): $date3", 0, 1, 'R');

        $this->Ln(3);
        $this->Cell(0,8,'        - against -',0,1);

        $this->Ln(3);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,$respondentName,0,1);
        $this->Cell(0,8,$respondentAddress,0,1);
        $this->SetFont('Arial','',11);
        $this->Cell(0,8,'Respondent',0,1);

        $this->Ln(5);
        $this->MultiCell(0,6,"      You are hereby required to appear before on this ".$formattedDate." ".$formattedTime." for the hearing of the above-entitled case of your complaint.");

        $this->Ln(15);
        $this->SetFont('Arial','BU',11);
        $this->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
        $this->SetFont('Arial','',10);
        $this->Cell(185,6,'Lupon Chairman',0,1,'R');

        $this->Ln(10);
        $this->Cell(40,8,'Received By: ____________________',0,1);
        $this->Cell(58,8,'Complainant\'s Name',0,1, 'R');

        $this->Ln(3);
        $this->Cell(40,8,'Date: ____________________________',0,1);
        $this->Cell(0,8,'Notified this _______ day of ________, 20__.',0,1);
        $this->Cell(0,8,'Served By: _________________________',0,1);
        $this->Cell(0,8,'Signature: __________________________',0,1);

        //Summons PDF
        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $complainantName, 0, 0);
        $this->Cell(90, 8, 'Barangay Case Number. '.$docketNo, 0, 1, 'R');
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $complainantAddress, 0, 0);
        $this->Cell(90, 8, 'FOR: '.$caseTitle, 0, 1, 'R');
        $this->SetFont('Arial','',11);
        $this->Cell(100, 8, 'Complainant', 0, 1);
        
        $this->Ln(3);
        $this->Cell(0,8,'        - against -',0,1);

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $respondentName, 0, 0);
        $this->SetFont('Arial','',11);
        $hearing1 = $hearingTypes[0] ?? '1st Hearing';
        $date1 = $hearingDates[0] ?? '';
        $this->Cell(90, 8, "$hearing1 (mediation): $date1", 0, 1, 'R');
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $respondentAddress, 0, 0);
        $this->SetFont('Arial','',11);
        $hearing2 = $hearingTypes[1] ?? '2nd Hearing';
        $date2 = $hearingDates[1] ?? '';
        $this->Cell(90, 8, "$hearing2 (mediation): $date2", 0, 1, 'R');
        $this->Cell(100, 8, 'Respondent', 0, 0);
        $this->SetFont('Arial','',11);
        $hearing3 = $hearingTypes[2] ?? '3rd Hearing';
        $date3 = $hearingDates[2] ?? '';
        $this->Cell(90, 8, "$hearing3 (mediation): $date3", 0, 1, 'R');

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,'SUMMONS MEDIATION',0,1,'C');

        $this->Ln(3);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,'TO: '.$respondentName,0,1);
        $this->SetFont('Arial','',11);
        $this->Cell(0,8,'Respondent',0,1);

        $this->Ln(3);
        $this->SetFont('Arial','',11);
        $this->MultiCell(0,8,"      You are hereby summoned to appear before me in person, together with your witnesses, on the ".$formattedDate.' '.$formattedTime.', then and there to answer to a complaint made before me for mediation of your dispute with the complainant/s.'.
        "\n"."      You are hereby warned that if you refuse or willfully fail to appear in obedience to this summons, you may be barred from filing any counterclaim arising from said complaint.".
        "\n".'FAIL NOT or else face punishment as for indirect contempt of court.');
        
        $this->Ln(15);
        $this->SetFont('Arial','BU',11);
        $this->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
        $this->SetFont('Arial','',10);
        $this->Cell(185,6,'Lupon Chairman',0,1,'R');

        return $this->Output('S');
    }

    public function GenerateSummaryBlob($hearingTypes, $hearingDates, $hearingDate, $hearingType, $hearingTime, $timePeriod) {
        $complainantName = $this->data['Complainant_Name'] ?? $this->data['complainant_name'] ?? 'N/A';
        $complainantAddress = $this->data['Complainant_Address'] ?? $this->data['complainant_address'] ?? 'N/A';
        $respondentName = $this->data['Respondent_Name'] ?? $this->data['respondent_name'] ?? 'N/A';
        $respondentAddress = $this->data['Respondent_Address'] ?? $this->data['respondent_address'] ?? 'N/A';
        $caseTitle = $this->data['Case_Title'] ?? $this->data['case_title'] ?? 'N/A';
        $docketNo = $this->data['Docket_Case_Number'] ?? $this->data['docket_case_number'] ?? 'N/A';
        $formattedDate = formatHearingDate($hearingDate);
        $formattedTime = "at {$hearingTime} o'clock in the " . ($timePeriod === 'AM' ? 'morning' : 'afternoon');

        // Notice of Hearing PDF
        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,'NOTICE OF HEARING',0,1,'C');
        $this->SetFont('Arial','',10);
        $this->Cell(0,6,'(MEDIATION PROCEEDINGS)',0,1,'C');

        $this->Ln(3);
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $complainantName, 0, 0);
        $this->SetFont('Arial','',11);
        $hearing1 = $hearingTypes[0] ?? '1st Hearing';
        $date1 = $hearingDates[0] ?? '';
        $this->Cell(90, 8, "$hearing1 (mediation): $date1", 0, 1, 'R');
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $complainantAddress, 0, 0);
        $this->SetFont('Arial','',11);
        $hearing2 = $hearingTypes[1] ?? '2nd Hearing';
        $date2 = $hearingDates[1] ?? '';
        $this->Cell(90, 8, "$hearing2 (mediation): $date2", 0, 1, 'R');
        $this->Cell(100, 8, 'Complainant', 0, 0);
        $this->SetFont('Arial','',11);
        $hearing3 = $hearingTypes[2] ?? '3rd Hearing';
        $date3 = $hearingDates[2] ?? '';
        $this->Cell(90, 8, "$hearing3 (mediation): $date3", 0, 1, 'R');

        $this->Ln(3);
        $this->Cell(0,8,'        - against -',0,1);

        $this->Ln(3);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,$respondentName,0,1);
        $this->Cell(0,8,$respondentAddress,0,1);
        $this->SetFont('Arial','',11);
        $this->Cell(0,8,'Respondent',0,1);

        $this->Ln(5);
        $this->MultiCell(0,6,"      You are hereby required to appear before on this ".$formattedDate." ".$formattedTime." for the hearing of the above-entitled case of your complaint.");

        $this->Ln(15);
        $this->SetFont('Arial','BU',11);
        $this->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
        $this->SetFont('Arial','',10);
        $this->Cell(185,6,'Lupon Chairman',0,1,'R');

        $this->Ln(10);
        $this->Cell(40,8,'Received By: ____________________',0,1);
        $this->Cell(58,8,'Complainant\'s Name',0,1, 'R');

        $this->Ln(3);
        $this->Cell(40,8,'Date: ____________________________',0,1);
        $this->Cell(0,8,'Notified this _______ day of ________, 20__.',0,1);
        $this->Cell(0,8,'Served By: _________________________',0,1);
        $this->Cell(0,8,'Signature: __________________________',0,1);

        //Summons PDF
        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $complainantName, 0, 0);
        $this->Cell(90, 8, 'Barangay Case Number. '.$docketNo, 0, 1, 'R');
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $complainantAddress, 0, 0);
        $this->Cell(90, 8, 'FOR: '.$caseTitle, 0, 1, 'R');
        $this->SetFont('Arial','',11);
        $this->Cell(100, 8, 'Complainant', 0, 1);
        
        $this->Ln(3);
        $this->Cell(0,8,'        - against -',0,1);

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $respondentName, 0, 0);
        $this->SetFont('Arial','',11);
        $hearing1 = $hearingTypes[0] ?? '1st Hearing';
        $date1 = $hearingDates[0] ?? '';
        $this->Cell(90, 8, "$hearing1 (mediation): $date1", 0, 1, 'R');
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $respondentAddress, 0, 0);
        $this->SetFont('Arial','',11);
        $hearing2 = $hearingTypes[1] ?? '2nd Hearing';
        $date2 = $hearingDates[1] ?? '';
        $this->Cell(90, 8, "$hearing2 (mediation): $date2", 0, 1, 'R');
        $this->Cell(100, 8, 'Respondent', 0, 0);
        $this->SetFont('Arial','',11);
        $hearing3 = $hearingTypes[2] ?? '3rd Hearing';
        $date3 = $hearingDates[2] ?? '';
        $this->Cell(90, 8, "$hearing3 (mediation): $date3", 0, 1, 'R');

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,'SUMMONS MEDIATION',0,1,'C');

        $this->Ln(3);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,'TO: '.$respondentName,0,1);
        $this->SetFont('Arial','',11);
        $this->Cell(0,8,'Respondent',0,1);

        $this->Ln(3);
        $this->SetFont('Arial','',11);
        $this->MultiCell(0,8,"      You are hereby summoned to appear before me in person, together with your witnesses, on the ".$formattedDate.' '.$formattedTime.', then and there to answer to a complaint made before me for mediation of your dispute with the complainant/s.'.
        "\n"."      You are hereby warned that if you refuse or willfully fail to appear in obedience to this summons, you may be barred from filing any counterclaim arising from said complaint.".
        "\n".'FAIL NOT or else face punishment as for indirect contempt of court.');
        
        $this->Ln(15);
        $this->SetFont('Arial','BU',11);
        $this->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
        $this->SetFont('Arial','',10);
        $this->Cell(185,6,'Lupon Chairman',0,1,'R');

        //summary page
        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

        $this->Ln(3);
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $complainantName, 0, 0);
        $this->SetFont('Arial','',11);
        $hearing1 = $hearingTypes[0] ?? '1st Hearing';
        $date1 = $hearingDates[0] ?? '';
        $this->Cell(90, 8, "$hearing1 (mediation): $date1", 0, 1, 'R');
        $this->SetFont('Arial','B',11);
        $this->Cell(100, 8, $complainantAddress, 0, 0);
        $this->SetFont('Arial','',11);
        $hearing2 = $hearingTypes[1] ?? '2nd Hearing';
        $date2 = $hearingDates[1] ?? '';
        $this->Cell(90, 8, "$hearing2 (mediation): $date2", 0, 1, 'R');
        $this->Cell(100, 8, 'Complainant', 0, 0);
        $this->SetFont('Arial','',11);
        $hearing3 = $hearingTypes[2] ?? '3rd Hearing';
        $date3 = $hearingDates[2] ?? '';
        $this->Cell(90, 8, "$hearing3 (mediation): $date3", 0, 1, 'R');

        $this->Ln(3);
        $this->Cell(0,8,'        - against -',0,1);

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,$respondentName,0,1);
        $this->Cell(0,8,$respondentAddress,0,1);
        $this->SetFont('Arial','',11);
        $this->Cell(0,8,'Respondent',0,1);

        $this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,8,'SUMMARY RECORD OF MINUTES OF PROCEEDINGS',0,1,'C');
        $this->SetFont('Arial','',11);
        $this->Cell(0,8,'MEDIATIONS',0,1,'C');

        $this->Ln(3);
        $this->SetFont('Arial','',11);
        $this->MultiCell(0,8,'       '.$this->data['report_summary_text'] ?? 'No summary record available.');

        $this->Ln(5);
        $this->Cell(0,8,'Patunay ang lagda ng mga kinauukulan',0,1);

        $this->Ln(5);
        $this->Cell(50,8,'Complainant:',0,0);
         $this->SetFont('Arial','B',11);
        $this->Cell(16,8,$complainantName,0,1, 'R');

        $this->Ln(5);
         $this->SetFont('Arial','',11);
        $this->Cell(50,8,'Respondent:',0,0);
        $this->SetFont('Arial','B',11);
        $this->Cell(15,8,$respondentName,0,1, 'R');

        $this->Ln(5);
        $this->Cell(0,8,'Records Taken by:',0,1);

        $this->Ln(5);
        $this->SetFont('Arial','',11);
        $this->Cell(0,8,'RECORDS KEEPER NAME',0,1);

        return $this->Output('S');
    }
}
