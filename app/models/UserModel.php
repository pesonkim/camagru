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

    //compare login password to database, return user data if verify matches
    public function loginUser($username, $passwd) {
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

    //get user data by username
    public function getUserData($username) {
        $stmt = $this->pdo->prepare('SELECT id_user, username, email, is_verified, notify_pref, token
                                    FROM users WHERE username = :username');
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user;
    }

    //get user data by email
    public function getUserDataByEmail($email) {
        $stmt = $this->pdo->prepare('SELECT id_user, username, email, token
                                    FROM users WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user;
    }

    //auth user data by id and token
    public function authUserByIdToken($id, $token, $passwd) {
        $stmt = $this->pdo->prepare('SELECT id_user, passwd FROM users WHERE id_user = :id_user AND token = :token');
        $stmt->bindValue(':id_user', $id);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
        $hash = $stmt->fetch();
        if (password_verify($passwd, $hash['passwd']))
            return $hash['id_user'];
        else
            return false;
    }

    //get user data by username
    public function getTokenById($id) {
        $stmt = $this->pdo->prepare('SELECT token FROM users WHERE id_user = :id_user');
        $stmt->bindValue(':id_user', $id);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user['token'];
    }

    //update verified status
    public function updateVerified($id) {
        $stmt = $this->pdo->prepare('UPDATE users SET is_verified = :is_verified WHERE id_user = :id_user');
        $stmt->bindValue(':id_user', $id);
        $stmt->bindValue(':is_verified', '1');
        $stmt->execute();
    }

    //generate a new token for user to prevent using old email verifications
    public function updateToken($id, $token) {
        $stmt = $this->pdo->prepare('UPDATE users SET token = :token WHERE id_user = :id_user');
        $stmt->bindValue(':id_user', $id);
        $stmt->bindValue(':token', $token);
        $stmt->execute();
    }

    //update username
    public function updateUsername() {

    }

    //update email
    public function updateEmail() {

    }

    //update password
    public function updatePassword($id, $passwd) {
        $stmt = $this->pdo->prepare('UPDATE users SET passwd = :passwd WHERE id_user = :id_user');
        $stmt->bindValue(':id_user', $id);
        $stmt->bindValue(':passwd', $passwd);
        $stmt->execute();
    }

    //update notification preference
    public function updateNotification() {

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