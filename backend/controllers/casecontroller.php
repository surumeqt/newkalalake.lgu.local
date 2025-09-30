<?php

namespace backend\controllers;

use backend\models\casemodel;
use Exception;

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
        return $this->caseModel->getCasesByStatus('Ongoing');
    }
    public function getRehearingCases() {
        return $this->caseModel->getCasesByStatus('Rehearing');
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
            $hearingStatus = $_POST['hearing_status'] ?? '';
            var_dump($hearingStatus);
            $caseId = $this->caseModel->findById($caseNumber);
            if (!empty($caseId)) {
                try {
                    $this->caseModel->updateStatus($caseId['case_id'], $hearingStatus);
                    header("Location: /lupon/pending-cases?success=1");
                    exit;
                } catch (Exception $e) {
                    echo "Error updating status: ". $e->getMessage();
                }
            }
        }
    }
    public function deleteCase(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $caseNumber = $_POST['case_id'] ?? '';
            $caseId = $this->caseModel->findById($caseNumber);
            if (!empty($caseId)) {
                $this->caseModel->deleteCaseById($caseId['case_id']);
                header("Location: /lupon/pending-cases?success=1");
                exit;
            } else {
                header("Location: /lupon/pending-cases?success=1");
                exit;
            }
        }
    }
    public function addSummary() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $caseNumber = $_POST['case_id'] ?? '';
            $summaryText = $_POST['summary_text'] ?? '';
            $summaryDate = $_POST['summary_date'] ?? '';
            $summaryTime = $_POST['summary_time'] ?? '';
            
        }
    }
}