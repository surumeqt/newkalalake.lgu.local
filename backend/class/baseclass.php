<?php

namespace backend\class;

use backend\config\Connection;

abstract class baseclass {
    protected $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }
    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
}
