<?php
require_once 'backend/lib/fpdf.php';

$headerPath = 'app/images/header.png';
$footerPath = 'app/images/footer.png';
$pdfbglogo = 'frontdesk/images/pdfbglogo.png';

$pdf = new FPDF();

// FIRST TIME JOB SEEKER

$pdf->AddPage();
$pdf->Image($pdfbglogo, 25, 70, 160, 160);
$pdf->Image($headerPath, 1, 1, 208, 45);

$pdf->Ln(30);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 20);
$pdf->Cell(0, 10, 'C E R T I F I C A T I O N', 0, 1, 'C');
$pdf->SetFont('Times', '', 15);
$pdf->Cell(0, 10, '( First Time Job Seekers Assistance Act - RA 11261 )', 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(0, 5, 'To Whom It May Concern', 0, 1);

$pdf->Ln(5);
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, "         This is to certify that ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "John Kenneth Almazan Esmena, 22 y/o");
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, " is presently residing at ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "#129 Jones Street, New Kalalake, Olongapo City");
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, " is qualified to avail the ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "RA 11261 or The First Time Job Seekers Assistance Act of 2019.");

$pdf->Ln(10);
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(0, 5, '         This further certifies that the holder/bearer was informed of his/her rights, including the duties and responsibilities accorded by RA 11261 through the OATH OF UNDERTAKING he/she has signed and excuted in the presence of Barangay Officials.', 0);

$pdf->Ln(5);
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, "Issued this ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "29 day of July 2025");
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, " at Barangay New Kalalake, Olongapo City.");

$pdf->Ln(40);
$pdf->SetFont('Times','B',13);
$pdf->Cell(0,8,'_______________________',0,1,'R');
$pdf->Cell(0,8,'Hon. Sherwin C. Sionzon',0,1,'R');
$pdf->SetFont('Times','',12);
$pdf->Cell(180,6,'Punong Barangay',0,1,'R');

$pdf->Image($footerPath, 1, 260, 208, 45);

// CERTIFICATE OF LOW-INCOME

$pdf->AddPage();
$pdf->Image($pdfbglogo, 25, 70, 160, 160);
$pdf->Image($headerPath, 1, 1, 208, 45);

$pdf->Ln(30);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 20);
$pdf->Cell(0, 10, 'C E R T I F I C A T I O N  O F  L O W - I N C O M E', 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(0, 5, 'To Whom It May Concern', 0, 1);

$pdf->Ln(5);
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, "         This is to certify that ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "John Kenneth Almazan Esmena");
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, ", presently residing at ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "#129 Jones Street, New Kalalake, Olongapo City");
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, " belongs to indigent family of his Barangay.");

$pdf->Ln(10);
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(0, 5, '         This further certifies that the above-mentioned name belong to low income families of this barangay, is employed with a monthly income of Php 3,000 as Avon Seller.', 0);

$pdf->Ln(5);
$pdf->MultiCell(0, 5, "This certificate is issued upon the request of the above-mentioned for whatever legal purpose this may serve.", 0);

$pdf->Ln(5);
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, "Issued this ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "29 day of July 2025");
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, " at Barangay New Kalalake, Olongapo City.");

$pdf->Ln(40);
$pdf->SetFont('Times','B',13);
$pdf->Cell(0,8,'_______________________',0,1,'R');
$pdf->Cell(0,8,'Hon. Sherwin C. Sionzon',0,1,'R');
$pdf->SetFont('Times','',12);
$pdf->Cell(180,6,'Punong Barangay',0,1,'R');

$pdf->Ln(65);
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(0, 10, 'Note: Valid Only with official dry seal and within (90) days from the date issued.', 0, 1);

$pdf->Image($footerPath, 1, 260, 208, 45);


// OATH OF UNDERTAKING

$pdf->AddPage();
$pdf->Image($pdfbglogo, 25, 70, 160, 160);
$pdf->Image($headerPath, 1, 1, 208, 45);

$pdf->Ln(30);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 20);
$pdf->Cell(0, 10, 'OATH OF UNDERTAKING', 0, 1, 'C');
$pdf->SetFont('Times', 'B', 15);
$pdf->Cell(0, 10, 'Republic Act No. 11261 - First Time Jobseekers Assistance Act', 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Times', '', 12);
$pdf->Write(7, "         I, ");
$pdf->SetFont('Times', 'BU', 12);
$pdf->Write(7, "John Kenneth Almazan Esmena, 18 years of age");
$pdf->SetFont('Times', '', 12);
$pdf->Write(7, ", resident of ");
$pdf->SetFont('Times', 'BU', 12);
$pdf->Write(7, "#129 Jones Street, New Kalalake, Olongapo City");
$pdf->SetFont('Times', '', 12);
$pdf->Write(7, ", availing the benefits of Republic Act No. 11261, Otherwise known as the First Time Jobseekers Act of 2019, do hereby declare, agree, and undertake to abide and to bound by the following:");

$pdf->Ln(10);
$pdf->Write(5, "1. That this is the first time that will actively look for a job, and therefore requesting that a Barangay Certification be issued in my favor to avail the benefits of the law;");
$pdf->Ln(10);
$pdf->Write(5, "2. That I am aware that the benefits and privileges under the said law shall be valid only for one (1) year from the date that the Barangay Certification is issued.");
$pdf->Ln(10);
$pdf->Write(5, "3. That I can avail the benefits of the law only once;");
$pdf->Ln(10);
$pdf->Write(5, "4. That I understand that my personal information shall be included in the Roaster/List of The First Time Jobseekers and will not be used for any unlawful purpose;");
$pdf->Ln(10);
$pdf->Write(5, "5. That I will not inform and report to the Barangay personally, through text or other means or through my family/relatives once I get employed; and");
$pdf->Ln(10);
$pdf->Write(5, "6. That I am not beneficiary of the Job Start Program under R.A No.10869 and other laws, that give similar exemptions for the documents or transactions exempted under R.A. No. 11261.");
$pdf->Ln(10);
$pdf->Write(5, "7. That if issued the certification, I will not use the same in my fraud, neither falsify not help and assists in the fabrication of the said certification.");
$pdf->Ln(10);
$pdf->Write(5, "8. That this undertaking is made solely for the purpose of obtaining a Barangay Certification consistent with the objectives of R.A. No.11261 and not for any other purpose");
$pdf->Ln(10);
$pdf->Write(5, "9. That I consent to the use of my personal information pursuant to the Data Privacy Act and other applicable laws, and regulations.");

$pdf->Ln(10);
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, "Issued this ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "29 day of July 2025");
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, " at Barangay New Kalalake, Olongapo City.");

$pdf->Ln(10);
$pdf->Cell(100,8,'Signed By:',0,0);
$pdf->Cell(90,8,'Witnessed By:',0,1,'R');

$pdf->Ln(5);
$pdf->SetFont('Times','BU',13);
$pdf->Cell(100,8,'JOHN KENNETH ESMENA',0,0);
$pdf->Cell(90,8,'HON. SHERWIN C. SIONZON',0,1, 'R');
$pdf->SetFont('Times','',12);
$pdf->Cell(180,6,'Punong Barangay',0,1,'R');

$pdf->Image($footerPath, 1, 260, 208, 45);


// BARANGAY CLEARANCE

$pdf->AddPage();
$pdf->Image($pdfbglogo, 25, 70, 160, 160);
$pdf->Image($headerPath, 1, 1, 208, 45);

$pdf->Ln(30);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 20);
$pdf->Cell(0, 10, 'BARANGAY CLEARANCE', 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(0, 5, 'To Whom It May Concern', 0, 1);

$pdf->Ln(10);
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, "         As per barangay records, this is to certify that, ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "John Kenneth Almazan Esmena, 18 year/old");
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, ", Born on ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "November 04, 2002");
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, " is a bonafide resident at ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "#129 Jones Street, New Kalalake, Olongapo City.");

$pdf->ln(10);
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(0, 5, '         This certifies further that the above named person has no derogatory records or complaints filed against the person is known to me as a law abiding citizen of this community with good moral character.');

$pdf->Ln(5);
$pdf->Write(5, "         This certificate is issued upon the request of the above-mentioned for ");
$pdf->SetFont('Times', 'B', 11);
$pdf->Write(5, "NDI REQUIREMENT PURPOSES");
$pdf->SetFont('Times', '', 11);
$pdf->Write(5, " and for whatever legal intent it may serve.");

$pdf->Ln(10);
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, "Issued this ");
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(5, "29 day of July 2025");
$pdf->SetFont('Times', '', 12);
$pdf->Write(5, " at Barangay New Kalalake, Olongapo City.");

$pdf->Ln(40);
$pdf->SetFont('Times','B',13);
$pdf->Cell(0,8,'_______________________',0,1,'R');
$pdf->Cell(0,8,'Hon. Sherwin C. Sionzon',0,1,'R');
$pdf->SetFont('Times','',12);
$pdf->Cell(180,6,'Punong Barangay',0,1,'R');

$pdf->Ln(50);
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(0, 10, 'Note: Valid Only with official dry seal and within (90) days from the date issued.', 0, 1);

$pdf->Image($footerPath, 1, 260, 208, 45);

$pdf->Output();