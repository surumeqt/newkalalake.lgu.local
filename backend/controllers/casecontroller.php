<?php

namespace backend\controllers;

use backend\models\casemodel;

class casecontroller {
    private $caseModel;

    public function __construct() {
        $this->caseModel = new casemodel();
    }

    public function submitNewCase() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'case_number' => $_POST['case_number'] ?? '',
                'case_title' => $_POST['case_title'] ?? '',
                'case_nature' => $_POST['case_nature'] ?? '',
                'complainant_name' => $_POST['complainant_name'] ?? '',
                'complainant_address' => $_POST['complainant_address'] ?? '',
                'respondent_name' => $_POST['respondent_name'] ?? '',
                'respondent_address' => $_POST['respondent_address'] ?? '',
                'time_filed' => $_POST['time_filed'] ?? ''
            ];

            $success = $this->caseModel->createCase($data);

            if ($success) {
                header("Location: /lupon/new-cases?success=1");
                exit;
            } else {
                header("Location: /lupon/new-cases?success=0");
                exit;
            }
        }
    }
    public function getPendingCases() {
        return $this->caseModel->getCasesByStatus();
    }
    public function getPdf(){
        
        if (!isset($_GET['file'])) {
            http_response_code(400);
            exit("Invalid request");
        }

        $filename = basename($_GET['file']);
        $baseDir = rtrim(realpath($_ENV['DOCUMENT_ROOT']), DIRECTORY_SEPARATOR);
        $realPath = $baseDir . DIRECTORY_SEPARATOR . $filename;

        if (!file_exists($realPath)) {
            http_response_code(404);
            exit("File not found: " . $realPath);
        }

        if (file_exists($realPath)) {
            http_response_code(200);
            
            header('Content-Type: application/pdf');
            header("Content-Disposition: inline; filename=\"" . $filename . "\"");
            header('Content-Length: ' . filesize($realPath));
            readfile($realPath);
            exit;
        } else {
            http_response_code(404);
            echo "File not found";
        }
    }
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $caseNumber = $_POST['case_id'] ?? '';
            $caseId = $this->caseModel->findById($caseNumber);

            if ($caseId) {
                $success = $this->caseModel->updateStatus($caseId);
            }
        }
    }
}