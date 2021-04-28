<?php

require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function signup() {
        if(isset($_POST["action"]) && $_POST["action"] === "signup"
        && isset($_POST["username"])
        && isset($_POST["email"])
        && isset($_POST["password"])) {
            var_dump($_POST);
        }
        else
            echo "nay";
    }

    public function createUser() {

    }

    public function login() {
        $this->redirect("index.php?login=ok");
    }

    public function viewLogin() {
        require_once __DIR__ . '/../views/pages/login.php';
    }

    public function viewSignup() {
        require_once __DIR__ . '/../views/pages/signup.php';
    }

    public function viewAccount() {
        require_once __DIR__ . '/../views/pages/account.php';
    }

    public function viewGallery() {
        require_once __DIR__ . '/../views/pages/gallery.php';
    }

    public function redirect($url) {
        header("Location: " . $url);
    }
}