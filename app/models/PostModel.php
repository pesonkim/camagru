<?php

require_once __DIR__ . '/Database.php';

class PostModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getPosts() {
        
    }

}