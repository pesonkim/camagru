<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}

require_once __DIR__ . '/Database.php';

class PostModel {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public static function getPost($i) {
        $post = array();
        
        $post['name'] = 'Example post #' . $i;
        $post['img'] = 'https://source.unsplash.com/random/?sig=' . $i;
        $post['date'] = date("d M Y", mt_rand(1, time()));

        return ($post);
    }

}