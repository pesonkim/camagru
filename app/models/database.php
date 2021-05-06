<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not premitted");
}

class Database {
    private $dbh; //handle for database connection
    private static $instance; //instance of constructed connection
    
    private function __construct() //private constructor (singleton pattern) for only a single instance to exist
    {
        require DIRPATH . '/config/database.php'; //data source name variables
        try {
            $this->dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD); //creates connection
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die ("Database error: " . $e->getMessage() . PHP_EOL);
        }
    }
    public static function getInstance()
    {
        if (!isset(self::$instance)) { //check for instance
            self::$instance = new Database();
        }
        return self::$instance;
    }
}