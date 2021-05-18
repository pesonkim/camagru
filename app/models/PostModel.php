<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}

require_once __DIR__ . '/Database.php';

class PostModel {
    private $pdo;
    
    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->dbh;
    }

    //insert a new post into database
    public function createPost($data) {
        $stmt = $this->pdo->prepare('INSERT INTO users (username, email, passwd, token, created_at)
                                    VALUES (:username, :email, :passwd, :token, :created_at)');
        $stmt->bindValue(':username', $data['username']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':passwd', $data['password']);
        $stmt->bindValue(':token', $data['token']);
        $stmt->bindValue(':created_at', $data['created_at']);
        $stmt->execute();
    }

    //validation check before creating a post
    public function authUpload($username, $passwd) {
        $stmt = $this->pdo->prepare('SELECT id_user, username, email, passwd, is_verified, notify_pref
                                    FROM users WHERE username = :username');
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $hash = $stmt->fetch();

        if (password_verify($passwd, $hash['passwd']))
            return $hash;
        else
            return false;
    }


    public static function getPost($i) {
        $post = array();
        
        $post['name'] = 'Example post #' . $i;
        $post['img'] = 'https://source.unsplash.com/random/?sig=' . $i;
        $post['date'] = date("d M Y", mt_rand(1, time()));

        return ($post);
    }

}