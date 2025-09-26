<?php

function generatePdfFilename() {
    return uniqid('case_') . ".pdf";
}

function getPdfFullPath($filename) {
    $documentsDir = rtrim($_ENV['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR);

    if (!is_dir($documentsDir)) {
        mkdir($documentsDir, 0777, true);
    }

    return $documentsDir . DIRECTORY_SEPARATOR . $filename;
}