<?php

require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function signup() {
        $errors = array();
        $data = array();

        if (empty($_POST['username']) && $_POST['username'] !== '0') {
            $errors['username'] = 'Username is required.';
        }
        if (empty($_POST['email']) && $_POST['email'] !== '0') {
            $errors['email'] = 'Email is required.';
        }
        if (empty($_POST['password']) && $_POST['password'] !== '0') {
            $errors['password'] = 'Password is required.';
        }
        if (!empty($errors)) {
            $data['code'] = 400;
            $data['errors'] = $errors;
        }
        else if (!isset($_POST["action"]) || $_POST["action"] !== "signup") {
            $data['code'] = 401;
            $data['message'] = 'Not authorized!';
        }
        else {
            $this->createUser();
        }

        echo json_encode($data);
        exit ;

        //clear post data before redirect
    }

    public function createUser() {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = array();
        $data = array();

        if ($this->model->usernameExists($username)) {
            $errors['username'] = 'Username is already taken.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email.';
        }
        if ($this->model->emailExists($email)) {
            $errors['email'] = 'Email is already used in an account.';
        }
        if (!empty($errors)) {
            $data['code'] = 409;
            $data['errors'] = $errors;
        }
        else {
            $data['code'] = 200;
            $data['message'] = 'Success!';
        }

        //insert user into model here

        echo json_encode($data);
        exit ;
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