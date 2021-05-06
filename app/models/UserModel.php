<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not premitted");
}

require_once __DIR__ . '/Database.php';

class UserModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function usernameExists($username) {
        $data = array();
        $data[]= "asd";
        //return data if true, false otherwise

        if (in_array($username, $data)) {
            return $username;
        }        
        else
            return false;
    }

    public function emailExists($email) {
        return false;
    }
}