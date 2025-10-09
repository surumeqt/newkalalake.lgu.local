<?php

namespace backend\models;

use backend\class\tocase;
use backend\class\tohearings;
use backend\class\todocuments;

class casemodel {
    private $toCase;
    private $toHearings;
    private $toDocuments;

    public function __construct() {
        $this->toCase = new tocase();
        $this->toHearings = new tohearings();
        $this->toDocuments = new todocuments();
    }

    public function createCase($data) {
        try {
            // Insert into cases
            $caseId = $this->toCase->insertData($data);

            // Insert into hearings
            $this->toHearings->insertData([
                'case_id' => $caseId,
                'hearing_time' => $data['time_filed'],
                'hearing_date' => $data['date_filed']
            ]);

            // Insert into documents
            $data['case_id'] = $caseId;
            $this->toDocuments->insertData($data);

            return true;
        } catch (\Exception $e) {
            throw new \Exception("Failed to create case: " . $e->getMessage());
        }
    }
    public function getCasesByStatus($status) {
        return $this->toHearings->getCasesByStatus($status);
    }

    public function findById($caseId) {
        return $this->toCase->findById($caseId);
    }

    public function updateStatus($caseId, $hearingStatus) {
        return $this->toHearings->updateStatus($caseId, $hearingStatus);
    }

    public function deleteCaseById($caseId) {
        return $this->toCase->deleteCaseById($caseId);
    }
}
