<?php

require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    /*
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
    */

    public function signup() {
        $errors = array();
        $data = array();

        if (empty($_POST['username'])) {
            $errors['username'] = 'Username is required.';
        }
        if (empty($_POST['email'])) {
            $errors['email'] = 'Email is required.';
        }
        if (empty($_POST['password'])) {
            $errors['password'] = 'Password is required.';
        }
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
        }
        else {
            $data['success'] = true;
            $data['message'] = 'Success!';
        }

        echo json_encode($data);

        if ($data['success']) {
            $this->viewLogin();
        }
        else
            $this->viewSignup();

        //clear post data before redirect
    }

    public function login() {
        $errors = array();
        $data = array();

        if (empty($_POST['username'])) {
            $errors['username'] = 'Username is required.';
        }
        if (empty($_POST['password'])) {
            $errors['password'] = 'Password is required.';
        }
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
        }
        else {
            $data['success'] = true;
            $data['message'] = 'Success!';
        }

        echo json_encode($data);

        if ($data['success']) {
            $this->viewGallery();
        }
        else
            $this->viewLogin();

    }


    public function createUser() {

    }

    /*
    public function login() {
        $this->redirect('index.php?login=ok');
    }
    */

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