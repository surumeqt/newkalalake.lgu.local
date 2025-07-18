<?php
require_once 'backend/lib/fpdf.php';

$headerPath = 'app/images/header.png';
$footerPath = 'app/images/footer.png';

$pdf = new FPDF();

// BARANGAY ENDORSEMENT
$pdf->AddPage();
$pdf->Image($headerPath, 1, 1, 208, 45);

$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'OFFICE OF THE PUNONG BARANGAY', 0, 1, 'C');

$pdf->Ln(20);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(0, 10, 'BARANGAY ENDORSEMENT', 0, 1, 'C');

$pdf->Ln(20);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 5, "     This is to endorse Mary Joy Rutor Aube residing at 135 Norton Street, New Kalalake, Olongapo City and the registered operator of 3MJ'S SARI-SARI STORE located at No. 135 Norton Street, New Kalalake, Olongapo City.",0, 'J');

$pdf->Ln(5);
$pdf->MultiCell(0, 5, "        This endorsement is being issued in connection with their application for LOAN and for whatever legal purpose and intent it may best serve him.", 0, 'J');

$pdf->Ln(7);
$pdf->Cell(0, 10, "Issued this 14th day May 2025 at Barangay New Kalalake, Olongapo City.", 0, 1, 'J');

$pdf->Ln(35);
$pdf->SetFont('Arial','BU',11);
$pdf->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(185,6,'Lupon Chairman',0,1,'R');

$pdf->Ln(65);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 10, 'Note: Valid Only with official dry seal and within 1 year from the date issued.', 0, 1);

$pdf->Image($footerPath, 1, 260, 208, 45);

// BARANGAY PERMIT

$pdf->AddPage();
$pdf->Image($headerPath, 1, 1, 208, 45);

$pdf->Ln(60);
$pdf->SetFont('Arial', 'B', 15); 
$pdf->Cell(0, 10, 'BARANGAY PERMIT', 0, 1, 'C');
 
$pdf->Ln(20);
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 5, "     This is to certify that Mary Joy Rutor Aube residing at 135 Norton Street, New Kalalake, Olongapo City is the registered operator of 3MJ'S SARI-SARI STORE located at No. 135 Norton Street, New Kalalake, Olongapo City.", 0, 'J');

$pdf->Ln(10);
$pdf->Cell(0, 10, "     This permit is being issued upon their request for whatever purpose this may serve.", 0, 0, 'L');

$pdf->Ln(8);
$pdf->Cell(0, 10, "     Issued this 14th day May 2025 at Barangay New Kalalake, Olongapo City.", 0, 0, 'L');

$pdf->Ln(40);
$pdf->SetFont('Arial','BU',11);
$pdf->Cell(0,8,'Hon. Sherwin Sionzon',0,1,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(185,6,'Lupon Chairman',0,1,'R');

$pdf->Image($footerPath, 1, 260, 208, 45);

$pdf->Output();
