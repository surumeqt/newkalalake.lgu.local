<?php
require_once __DIR__ . '/../lib/fpdf.php';
require_once __DIR__ . '/../helpers/formatters.php';

class PDFGenerator extends FPDF {
    private $data;
    private $todaysDate;

    public function __construct($data) {
        parent::__construct();
        $this->data = $data;
        $this->todaysDate = date('Y-m-d');
    }

    function Header() {
        $bgPath = __DIR__ . '/../../frontdesk/images/pdfbglogo.png';
        if (file_exists($bgPath)) {
            $this->Image($bgPath, 25, 70, 160, 160);
        }

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
    public function generateIndigencyBlob(){

        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 15);
        $this->Cell(0, 10, 'CERTIFICATE OF INDIGENCY', 0, 1, 'C');

        $this->Ln(7);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 5, 'To Whom It May Concern', 0, 1);

        $this->Ln(5);
        $this->SetFont('Times', '', 11);
        $this->Write(5, "         This is to certify that ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, $this->data['resident_name']);
        $this->SetFont('Times', '', 11);
        $this->Write(5, ", ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, $this->data['resident_age']." years old");
        $this->SetFont('Times', '', 11);
        $this->Write(5, ", Born on ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, formatBirthdate($this->data['resident_birthdate']));
        $this->SetFont('Times', '', 11);
        $this->Write(5, " is a bonafide resident of ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, $this->data['resident_address'].".");
        
        $this->Ln(10);
        $this->SetFont('Times', '', 11);
        $this->MultiCell(0, 5, "         This certifies further that the above-mentioned person has no sufficient regular source of income and belongs to an indigent family.", 0, 'J');

        $this->Ln(5);
        $this->Write(5, "         This certificate is issued upon the request of the above-mentioned for ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, strtoupper($this->data['purpose']) . " PURPOSES.");

        $this->Ln(10);
        $this->Write(5, "Issued this ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, formatHearingDate($this->todaysDate));
        $this->SetFont('Times', '', 11);
        $this->Write(5, " at Barangay New Kalalake, Olongapo City.");

        $this->Ln(35);
        $this->SetFont('Times','BU',12);
        $this->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
        $this->SetFont('Times','',11);
        $this->Cell(185,6,'Lupon Chairman',0,1,'R');

        $this->Ln(50);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(0, 10, 'Note: Valid Only with official dry seal and within (90) days from the date issued.', 0, 1);

        return $this->Output('S');
    }
    public function generateResidencyBlob(){

        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 15);
        $this->Cell(0, 10, 'BARANGAY RESIDENCY', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 5, 'To Whom It May Concern', 0, 1);

        $this->Ln(5);
        $this->SetFont('Times', '', 11);
        $this->Write(5, "         As per record found in this office, this is to certify that ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, $this->data['resident_name']);
        $this->SetFont('Times', '', 11);
        $this->Write(5, ", ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, $this->data['resident_age'] . " years old");
        $this->SetFont('Times', '', 11);
        $this->Write(5, ", Born on ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, formatBirthdate($this->data['resident_birthdate']));
        $this->SetFont('Times', '', 11);
        $this->Write(5, " and presently residing at ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, $this->data['resident_address']);
        $this->SetFont('Times', '', 11);
        $this->Write(5, ", With Good Moral Character and law abiding citizen on this Barangay.");

        $this->Ln(10);
        $this->Write(5, "         This certificate is issued upon the request of the above-mentioned for ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, strtoupper($this->data['purpose']) . " PURPOSES.");
        $this->SetFont('Times', '', 11);
        $this->Write(5, " and whatever legal intent it may serve.");

        $this->Ln(10);
        $this->Write(5, "Issued this ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, formatHearingDate($this->todaysDate));
        $this->SetFont('Times', '', 11);
        $this->Write(5, " at Barangay New Kalalake, Olongapo City.");

        $this->Ln(35);
        $this->SetFont('Times','BU',12);
        $this->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
        $this->SetFont('Times','',11);
        $this->Cell(185,6,'Lupon Chairman',0,1,'R');

        return $this->Output('S');
    }

// ------------ PUTANGINA NEED BAGHUING

    public function generateNonResidencyBlob(){

        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 20);
        $this->Cell(0, 10, 'CERTIFICATION OF NON-RESIDENCY', 0, 1, 'C');

        $this->Ln(20);
        $this->SetFont('Times', 'B', 18);
        $this->Cell(0, 7, 'To Whom It May Concern', 0, 1);

        $this->Ln(5);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "    As per record found in this office, this is to certify that ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_name']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, ", whose reported address was ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_address']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, ", is NOT A RESIDENT of this Barangay.");

        $this->Ln(13);
        $this->Write(7, "This certification is issued for ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['purpose']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, " and for whatever legal purpose this may serve.");

        $this->Ln(13);
        $this->Write(7, "Issued this ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, formatHearingDate($this->todaysDate));
        $this->SetFont('Times', '', 15);
        $this->Write(7, " at Barangay New Kalalake, Olongapo City.");

        $this->Ln(35);
        $this->Cell(0, 0, 'Attested By:', 0, 1);

        $this->Ln(10);
        $this->SetFont('Times', 'B', 15);
        $this->Cell(100, 8, '_________________', 0, 0);
        $this->Cell(90, 8, '_______________________', 0, 1, 'R');
        $this->Cell(100, 8, 'Percival T. Roxas', 0, 0);
        $this->Cell(90, 8, 'Hon. Sherwin C. Sionzon', 0, 1, 'R');

        $this->SetFont('Times', '', 13);
        $this->Cell(100, 8, 'Barangay Secretary', 0, 0);
        $this->Cell(80, 8, 'Punong Barangay', 0, 1, 'R');

        return $this->Output('S');
    }

    public function generatePermitBlob(){

        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 20); 
        $this->Cell(0, 10, 'BARANGAY PERMIT', 0, 1, 'C');

        $this->Ln(11);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "       This is to grant ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_name']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, " permission to ");
        $this->SetFont('Times', '', 15);
        $this->Write(7, $this->data['purpose'] . ".");

        $this->Ln(10);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "       This permit is being issued upon their request for whatever purpose this may serve.");

        $this->Ln(10);
        $this->Write(7, "       Issued this ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, formatHearingDate($this->todaysDate));
        $this->SetFont('Times', '', 15);
        $this->Write(7, " at Barangay New Kalalake, Olongapo City.");

        $this->Ln(40);
        $this->SetFont('Times', 'B', 15);
        $this->Cell(0, 8, '____________________', 0, 1, 'R');
        $this->Cell(0, 8, 'Hon. Sherwin Sionzon', 0, 1, 'R');
        $this->SetFont('Times', '', 13);
        $this->Cell(185, 6, 'Punong Barangay', 0, 1, 'R');

        return $this->Output('S');
    }

    public function generateEndorsementBlob(){

        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

        $this->Ln(20);
        $this->SetFont('Times', 'B', 20);
        $this->Cell(0, 10, 'BARANGAY ENDORSEMENT', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "         This is to endorse ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_name']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, " residing at ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_address']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, " and the registered operator of ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_business_name']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, " located at ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_business_address'] . ".");

        $this->Ln(10);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "         This endorsement is being issued in connection with their application for ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, strtoupper($this->data['purpose']));
        $this->SetFont('Times', '', 15);
        $this->Write(7, " and for whatever legal purpose and intent it may best serve him.");

        $this->Ln(10);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "         Issued this ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, formatHearingDate($this->todaysDate));
        $this->SetFont('Times', '', 15);
        $this->Write(7, " at Barangay New Kalalake, Olongapo City.");

        $this->Ln(35);
        $this->SetFont('Times', 'B', 15);
        $this->Cell(0, 8, '________________________', 0, 1, 'R');
        $this->Cell(187, 8, 'Hon. Sherwin C. Sionzon', 0, 1, 'R');
        $this->SetFont('Times', '', 13);
        $this->Cell(178, 6, 'Punong Barangay', 0, 1, 'R');

        $this->Ln(50);
        $this->SetFont('Times', 'B', 10);
        $this->Cell(0, 10, 
            'Note: Valid Only with official dry seal and within 1 year from the date issued.', 
            0, 1
        );

        return $this->Output('S');
    }

    public function generateVClearanceBlob(){
        
        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 15);
        $this->Cell(0, 10, 'VEHICLE CLEARANCE', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 5, 'To Whom It May Concern', 0, 1);

        $this->Ln(5);
        $this->SetFont('Times', '', 11);
        $this->Write(5, "         This is to certify that, as records in this office ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, $this->data['resident_name'].", ".$this->data['resident_age'].", at ".$this->data['resident_address']);
        $this->SetFont('Times', '', 11);
        $this->Write(5, ", is a bonafide resident and law-abiding citizen of this community.");

        $this->Ln(10);
        $this->SetFont('Times', '', 11);
        $this->Write(5, "         This is to certify further that review of said records reveals that the vehicle describes hereunder ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, "HAS NOT BEEN INVOLVED IN ANY CRIMINAL ACTIVITY");
        $this->SetFont('Times', '', 11);
        $this->Write(5, " , and that there is ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, "NO PENDING ACTION OR CASES");
        $this->SetFont('Times', '', 11);
        $this->Write(5, " involving subject filed in the Lupong Tagapamayapa of this barangay");

        // First Table Header
        $this->Ln(10);
        $this->SetFont('Times', 'B', 11);
        $this->Cell(38, 10, 'Type', 1);
        $this->Cell(38, 10, 'Make', 1);
        $this->Cell(38, 10, 'Color', 1);
        $this->Cell(38, 10, 'Year Model', 1);
        $this->Cell(38, 10, 'Plate Number', 1);
        $this->Ln();

        // First Table Row
        $this->SetFont('Times', '', 11);
        $this->Cell(38, 10, $this->data['vehicle_type'], 1);
        $this->Cell(38, 10, $this->data['vehicle_make'], 1);
        $this->Cell(38, 10, $this->data['vehicle_color'], 1);
        $this->Cell(38, 10, $this->data['vehicle_year_model'], 1);
        $this->Cell(38, 10, $this->data['vehicle_plate_number'], 1);
        $this->Ln();

        // Vertical space between tables
        $this->Ln(5);

        // Second Table Header
        $this->SetFont('Times', 'B', 11);
        $this->Cell(48, 10, 'Body Number', 1);
        $this->Cell(48, 10, 'CR Number', 1);
        $this->Cell(48, 10, 'Motor Number', 1);
        $this->Cell(48, 10, 'Chasis Number', 1);
        $this->Ln();

        // Second Table Row
        $this->SetFont('Times', '', 11);
        $this->Cell(48, 10, $this->data['vehicle_body_number'], 1);
        $this->Cell(48, 10, $this->data['vehicle_cr_number'], 1);
        $this->Cell(48, 10, $this->data['vehicle_motor_number'], 1);
        $this->Cell(48, 10, $this->data['vehicle_chasis_number'], 1);
        $this->Ln();

        $this->Ln(5);
        $this->SetFont('Times', '', 11);
        $this->Write(5, "         This clearance is issued upon the request of the above-mentioned person in compliance with the requirements for
        the application of ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, strtoupper($this->data['purpose']));
        $this->SetFont('Times', '', 11);
        $this->Write(5, " of the above-described vehicle.");

        $this->Ln(10);
        $this->SetFont('Times', '', 11);
        $this->Write(5, "Issued this ");
        $this->SetFont('Times', 'B', 11);
        $this->Write(5, formatHearingDate($this->todaysDate));
        $this->SetFont('Times', '', 11);
        $this->Write(5, " at Barangay New Kalalake, Olongapo City.");

        $this->Ln(30);
        $this->SetFont('Times','BU',14);
        $this->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
        $this->SetFont('Times','',12);
        $this->Cell(185,6,'Punong Barangay',0,1,'R');

        return $this->Output('S');
    }
    public function generateJobSeekerBlob(){

        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

        $this->Ln(5);
        $this->SetFont('Times', 'B', 20);
        $this->Cell(0, 10, 'C E R T I F I C A T I O N', 0, 1, 'C');
        $this->SetFont('Times', '', 18);
        $this->Cell(0, 10, '( First Time Job Seekers Assistance Act - RA 11261 )', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 16);
        $this->Cell(0, 5, 'To Whom It May Concern', 0, 1);

        $this->Ln(5);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "         This is to certify that ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_name'].", ".$this->data['resident_age']." y/o");
        $this->SetFont('Times', '', 15);
        $this->Write(7, " is presently residing at ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_address']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, " is qualified to avail the ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, "RA 11261 or The First Time Job Seekers Assistance Act of 2019.");

        $this->Ln(10);
        $this->SetFont('Times', '', 15);
        $this->MultiCell(0, 7, '         This further certifies that the holder/bearer was informed of his/her rights, including the duties and responsibilities accorded by RA 11261 through the OATH OF UNDERTAKING he/she has signed and excuted in the presence of Barangay Officials.', 0);

        $this->Ln(5);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "Issued this ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, formatHearingDate($this->todaysDate));
        $this->SetFont('Times', '', 15);
        $this->Write(7, " at Barangay New Kalalake, Olongapo City.");

        $this->Ln(35);
        $this->SetFont('Times','B',15);
        $this->Cell(0,8,'_______________________',0,1,'R');
        $this->Cell(0,8,'Hon. Sherwin C. Sionzon',0,1,'R');
        $this->SetFont('Times','',13);
        $this->Cell(180,6,'Punong Barangay',0,1,'R');

        return $this->Output('S');
    }
    public function generateLowIncomeBlob(){

        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

        $this->Ln(15);
        $this->SetFont('Times', 'B', 20);
        $this->Cell(0, 10, 'C E R T I F I C A T I O N  O F  L O W - I N C O M E', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 16);
        $this->Cell(0, 5, 'To Whom It May Concern', 0, 1);

        $this->Ln(5);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "         This is to certify that ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_name']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, ", presently residing at ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_address']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, " belongs to indigent family of his Barangay.");

        $this->Ln(10);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "         This further certifies that the above-mentioned name belong to low income families of this barangay, is employed with a monthly income of Php ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_monthly_salary']);
        $this->SetFont('Times', '', 15);
        $this->Write(7, " as ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_occupation'].".");
        
        $this->Ln(10);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "         This certificate is issued upon the request of the above-mentioned for whatever legal purpose this may serve.");

        $this->Ln(10);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "Issued this ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, formatHearingDate($this->todaysDate));
        $this->SetFont('Times', '', 15);
        $this->Write(7, " at Barangay New Kalalake, Olongapo City.");

        $this->Ln(30);
        $this->SetFont('Times','B',15);
        $this->Cell(0,8,'_______________________',0,1,'R');
        $this->Cell(0,8,'Hon. Sherwin C. Sionzon',0,1,'R');
        $this->SetFont('Times','',13);
        $this->Cell(180,6,'Punong Barangay',0,1,'R');

        $this->Ln(40);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(0, 10, 'Note: Valid Only with official dry seal and within (90) days from the date issued.', 0, 1);

        return $this->Output('S');
    }
    public function generateOathofUndertakingBlob(){

        $this->AddPage();
        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

        $this->Ln(5);
        $this->SetFont('Times', 'B', 20);
        $this->Cell(0, 10, 'OATH OF UNDERTAKING', 0, 1, 'C');
        $this->SetFont('Times', 'B', 15);
        $this->Cell(0, 10, 'Republic Act No. 11261 - First Time Jobseekers Assistance Act', 0, 1, 'C');

        $this->Ln(5);
        $this->SetFont('Times', '', 12);
        $this->Write(7, "         I, ");
        $this->SetFont('Times', 'BU', 12);
        $this->Write(7, $this->data['resident_name'].", ".$this->data['resident_age']." years of age");
        $this->SetFont('Times', '', 12);
        $this->Write(7, ", resident of ");
        $this->SetFont('Times', 'BU', 12);
        $this->Write(7, $this->data['resident_address']);
        $this->SetFont('Times', '', 12);
        $this->Write(7, ", availing the benefits of Republic Act No. 11261, Otherwise known as the First Time Jobseekers Act of 2019, do hereby declare, agree, and undertake to abide and to bound by the following:");

        $this->Ln(10);
        $this->Write(5, "1. That this is the first time that will actively look for a job, and therefore requesting that a Barangay Certification be issued in my favor to avail the benefits of the law;");
        $this->Ln(10);
        $this->Write(5, "2. That I am aware that the benefits and privileges under the said law shall be valid only for one (1) year from the date that the Barangay Certification is issued.");
        $this->Ln(10);
        $this->Write(5, "3. That I can avail the benefits of the law only once;");
        $this->Ln(10);
        $this->Write(5, "4. That I understand that my personal information shall be included in the Roaster/List of The First Time Jobseekers and will not be used for any unlawful purpose;");
        $this->Ln(10);
        $this->Write(5, "5. That I will not inform and report to the Barangay personally, through text or other means or through my family/relatives once I get employed; and");
        $this->Ln(10);
        $this->Write(5, "6. That I am not beneficiary of the Job Start Program under R.A No.10869 and other laws, that give similar exemptions for the documents or transactions exempted under R.A. No. 11261.");
        $this->Ln(10);
        $this->Write(5, "7. That if issued the certification, I will not use the same in my fraud, neither falsify not help and assists in the fabrication of the said certification.");
        $this->Ln(10);
        $this->Write(5, "8. That this undertaking is made solely for the purpose of obtaining a Barangay Certification consistent with the objectives of R.A. No.11261 and not for any other purpose");
        $this->Ln(10);
        $this->Write(5, "9. That I consent to the use of my personal information pursuant to the Data Privacy Act and other applicable laws, and regulations.");

        $this->Ln(10);
        $this->SetFont('Times', '', 12);
        $this->Write(5, "Issued this ");
        $this->SetFont('Times', 'B', 12);
        $this->Write(5, formatHearingDate($this->todaysDate));
        $this->SetFont('Times', '', 12);
        $this->Write(5, " at Barangay New Kalalake, Olongapo City.");

        $this->Ln(10);
        $this->Cell(100,8,'Signed By:',0,0);
        $this->Cell(52,8,'Witnessed By:',0,1,'R');

        $this->Ln(5);
        $this->SetFont('Times','BU',13);
        $this->Cell(100,8,strtoupper($this->data['resident_name']),0,0);
        $this->Cell(90,8,'HON. SHERWIN C. SIONZON',0,1, 'R');
        $this->SetFont('Times','',12);
        $this->Cell(180,6,'Punong Barangay',0,1,'R');

        return $this->Output('S');
    }
    public function generateBarangayClearance(){

        $this->AddPage();
        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 20);
        $this->Cell(0, 10, 'BARANGAY CLEARANCE', 0, 1, 'C');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 16);
        $this->Cell(0, 5, 'To Whom It May Concern', 0, 1);

        $this->Ln(5);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "         As per barangay records, this is to certify that, ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_name'].", ".$this->data['resident_age']." year/old");
        $this->SetFont('Times', '', 15);
        $this->Write(7, ", Born on ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, formatBirthdate($this->data['resident_birthdate']));
        $this->SetFont('Times', '', 15);
        $this->Write(7, " is a bonafide resident at ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, $this->data['resident_address'].".");

        $this->ln(10);
        $this->SetFont('Times', '', 15);
        $this->MultiCell(0, 7, '         This certifies further that the above named person has no derogatory records or complaints filed against the person is known to me as a law abiding citizen of this community with good moral character.');

        $this->Ln(5);
        $this->Write(7, "         This certificate is issued upon the request of the above-mentioned for ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, strtoupper($this->data['purpose']));
        $this->SetFont('Times', '', 15);
        $this->Write(7, " and for whatever legal intent it may serve.");

        $this->Ln(10);
        $this->SetFont('Times', '', 15);
        $this->Write(7, "Issued this ");
        $this->SetFont('Times', 'B', 15);
        $this->Write(7, formatHearingDate($this->todaysDate));
        $this->SetFont('Times', '', 15);
        $this->Write(7, " at Barangay New Kalalake, Olongapo City.");

        $this->Ln(40);
        $this->SetFont('Times','B',15);
        $this->Cell(0,8,'_______________________',0,1,'R');
        $this->Cell(0,8,'Hon. Sherwin C. Sionzon',0,1,'R');
        $this->SetFont('Times','',13);
        $this->Cell(180,6,'Punong Barangay',0,1,'R');

        $this->Ln(30);
        $this->SetFont('Times', 'B', 8);
        $this->Cell(0, 10, 'Note: Valid Only with official dry seal and within (90) days from the date issued.', 0, 1);

        return $this->Output('S');
    }
}
// header("Content-Type: application/pdf");

// $data = [
//     'resident_name' => 'John Kenneth Almazan Esmena',
//     'resident_age' => '22',
//     'resident_address' => '123 Norton 14st. New Kalalake, Olongapo City',
//     'resident_monthly_salary' => '3000',
//     'resident_occupation' => 'Programmer',
//     'purpose' => 'MEDICAL ASSISTANCE',
//     'resident_business_name' => 'We Push Drugs Cuh',
//     'resident_business_address' => '123 Norton 14st. New Kalalake, Olongapo City'
// ];
// $pdf = new PDFGenerator($data);
// echo $pdf->generateBarangayClearance();