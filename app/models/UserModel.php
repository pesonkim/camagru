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

    //insert new user to database after verifications
    public function createUser() {

    }

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

    //search user by email
    public function getUserByEmail() {

    }

    //check if username is taken
    public function usernameExists($username) {
        $stmt = ('SELECT * FROM users WHERE username = :username');
        $this->pdo->prepare($stmt);
        $this->pdo->bindValue(':username', $username);
        $this->pdo->execute();
        $data = $this->pdo->fetch();
        return $data;
    }

    //check if email is registered
    public function emailExists($email) {
        $stmt = ('SELECT * FROM users WHERE email = :email');
        $this->pdo->prepare($stmt);
        $this->pdo->bindValue(':email', $email);
        $this->pdo->execute();
        $data = $this->pdo->fetch();
        return $data;
    }
}