<?php
require_once 'backend/lib/fpdf.php';

$headerPath = 'app/images/header.png';
$footerPath = 'app/images/footer.png';

$pdf = new FPDF();

// VEHICLE CLEARANCE

$pdf->AddPage();
$pdf->Image($headerPath, 1, 1, 208, 45);

$pdf->Ln(30);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Times', 'B', 15);
$pdf->Cell(0, 10, 'VEHICLE CLEARANCE', 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 5, 'To Whom It May Concern', 0, 1);

$pdf->Ln(5);
$pdf->SetFont('Times', '', 11);
$pdf->Write(5, "         This is to certify that, as records in this office ");
$pdf->SetFont('Times', 'B', 11);
$pdf->Write(5, "John Kenneth Almazan Esmena, 22 y/o, at #129 Jones Street, New Kalalake, Olongapo City");
$pdf->SetFont('Times', '', 11);
$pdf->Write(5, ", is a bonafide resident and law-abiding citizen of this community.");

$pdf->Ln(10);
$pdf->SetFont('Times', '', 11);
$pdf->Write(5, "         This is to certify further that review of said records reveals that the vehicle describes hereunder ");
$pdf->SetFont('Times', 'B', 11);
$pdf->Write(5, "HAS NOT BEEN INVOLVED IN ANY CRIMINAL ACTIVITY");
$pdf->SetFont('Times', '', 11);
$pdf->Write(5, " , and that there is ");
$pdf->SetFont('Times', 'B', 11);
$pdf->Write(5, "NO PENDING ACTION OR CASES");
$pdf->SetFont('Times', '', 11);
$pdf->Write(5, " involving subject filed in the Lupong Tagapamayapa of this barangay");

// First Table Header
$pdf->Ln(10);
$pdf->Cell(38, 10, 'Type', 1);
$pdf->Cell(38, 10, 'Make', 1);
$pdf->Cell(38, 10, 'Color', 1);
$pdf->Cell(38, 10, 'Year Model', 1);
$pdf->Cell(38, 10, 'Plate Number', 1);
$pdf->Ln();

// First Table Row
$pdf->Cell(38, 10, 'Tricycle', 1);
$pdf->Cell(38, 10, 'Kawasaki', 1);
$pdf->Cell(38, 10, 'Green', 1);
$pdf->Cell(38, 10, '2021', 1);
$pdf->Cell(38, 10, '273RUI', 1);
$pdf->Ln();

// Vertical space between tables
$pdf->Ln(5);

// Second Table Header
$pdf->Cell(48, 10, 'Body Number', 1);
$pdf->Cell(48, 10, 'CR Number', 1);
$pdf->Cell(48, 10, 'Motor Number', 1);
$pdf->Cell(48, 10, 'Chasis Number', 1);
$pdf->Ln();

// Second Table Row
$pdf->Cell(48, 10, '2487', 1);
$pdf->Cell(48, 10, '0001279559', 1);
$pdf->Cell(48, 10, 'BC1765AEBN1517', 1);
$pdf->Cell(48, 10, 'BC175H-BD2328', 1);
$pdf->Ln();

$pdf->Ln(5);
$pdf->SetFont('Times', '', 11);
$pdf->Write(5, "         This clearance is issued upon the request of the above-mentioned person in compliance with the requirements for
the application of ");
$pdf->SetFont('Times', 'B', 11);
$pdf->Write(5, "FRANCHISE RENEWAL/INSPECTION PURPOSES");
$pdf->SetFont('Times', '', 11);
$pdf->Write(5, " of the above-described vehicle.");

$pdf->Ln(10);
$pdf->SetFont('Times', '', 11);
$pdf->Write(5, "Issued this ");
$pdf->SetFont('Times', 'B', 11);
$pdf->Write(5, "14th day May 2025");
$pdf->SetFont('Times', '', 11);
$pdf->Write(5, " at Barangay New Kalalake, Olongapo City.");

$pdf->Ln(30);
$pdf->SetFont('Times','BU',14);
$pdf->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
$pdf->SetFont('Times','',12);
$pdf->Cell(185,6,'Punong Barangay',0,1,'R');

$pdf->Ln(20);
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(0, 10, 'Note: Valid Only with official dry seal and 1 year from the date issued.', 0, 1);

$pdf->Image($footerPath, 1, 260, 208, 45);

$pdf->Output();