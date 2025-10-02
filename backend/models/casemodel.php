<?php

namespace backend\models;

use backend\config\Connection;

class casemodel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    
}