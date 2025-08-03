<?php
require_once 'lib/fpdf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['images']) && isset($_POST['docketNumber'])) {
    $base64Images = $_POST['images'];
    $docketNumber = htmlspecialchars($_POST['docketNumber']);

    $pdf = new FPDF('P', 'mm', 'A4');

    foreach ($base64Images as $index => $base64) {
        $imageData = base64_decode($base64);

        $tempFilePath = tempnam(sys_get_temp_dir(), 'gallery_img_');
        if ($tempFilePath === false) {
            error_log("Failed to create temporary file for PDF generation.");
            http_response_code(500);
            echo "Error: Could not create temporary file.";
            exit;
        }

        file_put_contents($tempFilePath, $imageData);

        $pdf->AddPage();

        $imageInfo = getimagesize($tempFilePath);
        if ($imageInfo === false) {
            error_log("Failed to get image info for: " . $tempFilePath);
            unlink($tempFilePath);
            continue;
        }

        $imgWidth = $imageInfo[0];
        $imgHeight = $imageInfo[1];
        $imgType = image_type_to_mime_type($imageInfo[2]);

        $fpdfImgType = '';
        if (strpos($imgType, 'jpeg') !== false) {
            $fpdfImgType = 'JPEG';
        } elseif (strpos($imgType, 'png') !== false) {
            $fpdfImgType = 'PNG';
        } elseif (strpos($imgType, 'gif') !== false) {
            $fpdfImgType = 'GIF';
        } else {
            error_log("Unsupported image type: " . $imgType);
            unlink($tempFilePath);
            continue;
        }

        $pageWidth = $pdf->GetPageWidth() - 20;
        $pageHeight = $pdf->GetPageHeight() - 20;

        $ratio = $imgWidth / $imgHeight;
        $newWidth = $pageWidth;
        $newHeight = $newWidth / $ratio;

        if ($newHeight > $pageHeight) {
            $newHeight = $pageHeight;
            $newWidth = $newHeight * $ratio;
        }

        $x = ($pdf->GetPageWidth() - $newWidth) / 2;
        $y = ($pdf->GetPageHeight() - $newHeight) / 2;

        $pdf->Image($tempFilePath, $x, $y, $newWidth, $newHeight, $fpdfImgType);

        unlink($tempFilePath);
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Docket_Number_' . $docketNumber . '.pdf"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    ini_set('zlib.output_compression','0');

    $pdf->Output('I', 'Docket_Number_' . $docketNumber . '.pdf');

} else {
    http_response_code(400);
    echo "Error: Invalid request or missing data.";
}