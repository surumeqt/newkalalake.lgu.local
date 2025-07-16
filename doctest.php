<?php
require_once 'backend/lib/fpdf.php';

$headerPath = 'app/images/header.png';
$footerPath = 'app/images/footer.png';
$leftWidth = 100;
$rightWidth = 90;

$pdf = new FPDF();
$pdf->AddPage();

$pdf->Image($headerPath, 1, 1, 208, 45);

$pdf->Ln(30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

$pdf->Ln(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'NOTICE OF HEARING',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,'(MEDIATION PROCEEDINGS)',0,1,'C');

$pdf->Ln(3);
$pdf->SetFont('Arial','B',11);
$pdf->Cell($leftWidth, 8, 'ANGELA JEAN SUNIGA', 0, 0);
$pdf->SetFont('Arial','',11);
$pdf->Cell($rightWidth, 8, '1st Hearing (Mediation): MAY 27, 2025', 0, 1, 'R');
$pdf->SetFont('Arial','B',11);
$pdf->Cell($leftWidth, 8, '#148-A MURPHY STREET, NEW KALALAKE O.C.', 0, 0);
$pdf->SetFont('Arial','',11);
$pdf->Cell($rightWidth, 8, '2nd Hearing (Mediation)', 0, 1, 'R');
$pdf->Cell($leftWidth, 8, 'Complainant', 0, 0);
$pdf->Cell($rightWidth, 8, '3rd Hearing (Mediation)', 0, 1, 'R');

$pdf->Ln(3);
$pdf->Cell(0,8,'        - against -',0,1);

$pdf->Ln(3);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'PRINCE DAVID',0,1);
$pdf->Cell(0,8,'#151 GORDON AVENUE NEW KALALAKE O.C.',0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,'Respondent',0,1);

$pdf->Ln(5);
$pdf->MultiCell(0,6,'       You are hereby required to appear before on this 27th day of May, 2025 at 10:00 o\'clock in the morning for the hearing of the above-entitled case of your complaint.');

$pdf->Ln(3);
$pdf->Cell(0,8,'This 22nd day of May, 2025.',0,1);

$pdf->Ln(15);
$pdf->SetFont('Arial','BU',11);
$pdf->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(185,6,'Lupon Chairman',0,1,'R');

$pdf->Ln(10);
$pdf->Cell(40,8,'Received By: ____________________',0,1);
$pdf->Cell(58,8,'Complainant\'s Name',0,1, 'R');

$pdf->Ln(3);
$pdf->Cell(40,8,'Date: ____________________________',0,1);
$pdf->Cell(0,8,'Notified this _______ day of ________, 20__.',0,1);
$pdf->Cell(0,8,'Served By: _________________________',0,1);
$pdf->Cell(0,8,'Signature: __________________________',0,1);

$pdf->Image($footerPath, 1, 250, 208, 40);

// SUMMONS PAGE
$pdf->AddPage();
$pdf->Image($headerPath, 1, 1, 208, 45);

$pdf->Ln(30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

$pdf->Ln(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell($leftWidth, 8, 'ANGELA JEAN SUNIGA', 0, 0);
$pdf->Cell($rightWidth, 8, 'Barangay Case Number. NK-05-11-25', 0, 1, 'R');
$pdf->SetFont('Arial','B',11);
$pdf->Cell($leftWidth, 8, '#148-A MURPHY STREET, NEW KALALAKE O.C.', 0, 0);
$pdf->Cell($rightWidth, 8, 'FOR: PAGMUMURA AT PAMBABASTOS', 0, 1, 'R');
$pdf->SetFont('Arial','',11);
$pdf->Cell($leftWidth, 8, 'Complainant', 0, 1);

$pdf->Ln(3);
$pdf->Cell(0,8,'        - against -',0,1);

$pdf->Ln(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell($leftWidth,8,'PRINCE DAVID',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0, 8, '1st Hearing (Mediation): MAY 27, 2025', 0, 1, 'R');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'#151 GORDON AVENUE NEW KALALAKE O.C.',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0, 8, '2nd Hearing (Mediation)', 0, 1, 'R');
$pdf->Cell(0,8,'Respondent',0,0);
$pdf->Cell(0, 8, '3rd Hearing (Mediation)', 0, 1, 'R');

$pdf->Ln(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'SUMMONS MEDIATION',0,1,'C');

$pdf->Ln(3);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'TO: PRINCE DAVID',0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,'Respondent',0,1);

$pdf->Ln(3);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,8,'       You are hereby summoned to appear before the Barangay Lupon on this 27th day of May, 2025 at 10:00 o\'clock in the morning for the hearing of the above-entitled case of your complaint.');

$pdf->Ln(15);
$pdf->SetFont('Arial','BU',11);
$pdf->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(185,6,'Lupon Chairman',0,1,'R');

$pdf->Image($footerPath, 1, 250, 208, 40);

// SUMMARY PAGE
$pdf->AddPage();

$pdf->Image($headerPath, 1, 1, 208, 45);

$pdf->Ln(30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,8,'OFFICE OF THE LUPONG TAGAPAMAYAPA',0,1,'C');

$pdf->Ln(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell($leftWidth, 8, 'ANGELA JEAN SUNIGA', 0, 0);
$pdf->SetFont('Arial','',11);
$pdf->Cell($rightWidth, 8, '1st Hearing (Mediation): MAY 27, 2025', 0, 1, 'R');
$pdf->SetFont('Arial','B',11);
$pdf->Cell($leftWidth, 8, '#148-A MURPHY STREET, NEW KALALAKE O.C.', 0, 0);
$pdf->SetFont('Arial','',11);
$pdf->Cell($rightWidth, 8, '2nd Hearing (Mediation)', 0, 1, 'R');
$pdf->Cell($leftWidth, 8, 'Complainant', 0, 0);
$pdf->Cell($rightWidth, 8, '3rd Hearing (Mediation)', 0, 1, 'R');

$pdf->Ln(3);
$pdf->Cell(0,8,'        - against -',0,1);

$pdf->Ln(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'PRINCE DAVID',0,1);
$pdf->Cell(0,8,'#151 GORDON AVENUE NEW KALALAKE O.C.',0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,'Respondent',0,1);

$pdf->Ln(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'SUMMARY RECORD OF MINUTES OF PROCEEDINGS',0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,'MEDIATIONS',0,1,'C');

$pdf->Ln(3);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,8,'       '.$reportSummaryText);

$pdf->Ln(5);
$pdf->Cell(0,8,'Patunay ang lagda ng mga kinauukulan',0,1);

$pdf->Ln(5);
$pdf->Cell(50,8,'Complainant:',0,0);
$pdf->Cell(16,8,$complainantName,0,1, 'R');

$pdf->Ln(5);
$pdf->Cell(50,8,'Respondent:',0,0);
$pdf->Cell(15,8,$respondentName,0,1, 'R');

$pdf->Ln(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'Records Taken by:',0,1);

$pdf->Ln(5);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,'RECORDS KEEPER NAME',0,1);

$pdf->Image($footerPath, 1, 250, 208, 40);

$pdf->Output();
