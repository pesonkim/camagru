<?php

require_once __DIR__ . '/Database.php';

class UserModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }

}