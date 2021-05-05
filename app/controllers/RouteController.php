<?php

//parses given url path in a format of /controller/method/parameters
class RouteController {
    private $controller;
    private $method;

    public function __construct() {
        //default controller and method to include, if no other path was specified
        $this->controller = 'Post';
        $this->method = 'viewGallery';
    }
    public function route($urlPath) {
        $url = preg_split('#/#', $urlPath);

        //removing dirname as the first array element
        if ($url[0] == DIRROOT) {
            array_shift($url);
        }
        
        //check if a controller was requested and it exists
        if ($url[0]) {
            $filename = DIRPATH . '/app/controllers/';
            $filename .= ucfirst($url[0]) . 'Controller.php';
            //set as new controller if true
            if (file_exists($filename)) {
                $this->controller = ucfirst($url[0]);
                array_shift($url);
            }
        }

        //include and create instance of controller
        $this->controller .=  'Controller';
        require_once DIRPATH . '/app/controllers/' . $this->controller . '.php';
        
        $routedController = new $this->controller;

        //check if a method was requested and it exists
        if ($url[0]) {
            echo $url[0] . PHP_EOL;
            if (method_exists($routedController, $url[0])) {
                $this->method = $url[0];
                array_shift($url);
            }
        }

        //call default or valid requested method
        $routedMethod = $this->method;
        $routedController->$routedMethod();
    }
}

/*
class Database {
    private $dbh; //handle for database connection
    private static $instance; //instance of constructed connection
    
    private function __construct() //private constructor (singleton pattern) for only a single instance to exist
    {
        require __DIR__ . '/../../config/database.php'; //data source name variables
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
*/