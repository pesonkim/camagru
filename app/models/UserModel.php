<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not premitted");
}

require_once __DIR__ . '/Database.php';

class UserModel {
    private $pdo;
    
    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->dbh;
    }

    //insert new user to database after verifications
    public function createUser($data) {

        $stmt = $this->pdo->prepare('INSERT INTO users (username, email, passwd, token, created_at)
                                    VALUES (:username, :email, :passwd, :token, :created_at)');
        $stmt->bindValue(':username', $data['username']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':passwd', $data['password']);
        $stmt->bindValue(':token', $data['token']);
        $stmt->bindValue(':created_at', $data['created_at']);
        $stmt->execute();
    }

    //authenticate user data after creation
    /*
    public function authUserData($username, $password) {
        $stmt = $this->pdo->prepare('SELECT id_user, passwd, email, token FROM users WHERE username = :username');
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $hashed = $stmt->fetch();
        
        if (password_verify($password, $hashed['passwd'])) {
            return $hashed;
        }
        return false;
    }
    */

    //compare login password to database
    public function loginUser() {

    }

    //update username
    public function updateUsername() {

    }

    //update email
    public function updateEmail() {

    }

    //update password
    public function updatePassword() {

    }

    //update verified status
    public function updateVerified() {

    }

    //update notification preference
    public function updateNotification() {

    }

    //check if account is verified by email
    public function isVerified() {

    }

    //check if username is taken
    public function usernameExists($username) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

    //check if email is registered
    public function emailExists($email) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }
}