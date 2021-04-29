<?php

require_once __DIR__ . '/Database.php';

class UserModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function usernameExists($username) {
        //return data if true, false otherwise
        return true;
    }

    public function emailExists($email) {
        return true;
    }
}