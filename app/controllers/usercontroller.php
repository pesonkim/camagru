<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not premitted");
}

require_once DIRPATH . '/app/models/UserModel.php';

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function signupUser() {
        $errors = array();
        $data = array();

        if (isset($_POST["action"]) && $_POST["action"] === "signup") {
            $errors['username'] = $this->validateUsernameFormat();
            $errors['email'] = $this->validateEmailFormat();
            $errors['password'] = $this->validatePasswordFormat();

            if (!empty($errors)) {
                $data['code'] = 400;
                $data['errors'] = $errors;
            }
            else {
                $this->createUser($data);
            }
        }
        else {
            $data['code'] = 401;
            $data['message'] = 'Not authorized!';
        }
        echo json_encode($data);
        exit ;
    }

    public function validateUsernameFormat() {
        if (empty($_POST['username'])) {
            $error = 'Please enter a username.';
        }
        else if (strlen($_POST['username']) <  4) {
            $error = 'Username must be at least 4 characters long.';
        }
        else if (!preg_match('/^[A-Za-z0-9]+$/', $_POST['username'])) {
            $error = 'Username can only contain letters and numbers.';
        }
        else if (strlen($_POST['username']) >  25) {
            $error = 'Username cannot be more than 25 characters long.';
        }
        if (!isset($_POST["action"])) {
            $errors = array();
            if (isset($error)) {
                $errors['username'] = $error;
            }
            echo json_encode($errors);
            exit ;
        }
        if (isset($error)) {
            return $error;
        }
    }

    public function validateEmailFormat() {
        if (empty($_POST['email'])) {
            $error = 'Please enter an email address.';
        }
        else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        }
        if (!isset($_POST["action"])) {
            $errors = array();
            if (isset($error)) {
                $errors['email'] = $error;
            }
            echo json_encode($errors);
            exit ;
        }
        if (isset($error)) {
            return $error;
        }
    }

    public function validatePasswordFormat() {
        if (empty($_POST['password'])) {
            $error = 'Please enter a password.';
        }
        else if (strlen($_POST['password']) <  6) {
            $error = 'Password must be at least 6 characters long.';
        }
        else if (!preg_match('/^(?=.*[0-9])(?=.*[A-Z]).{6,}$/', $_POST['password'])) {
            $error = 'Password must contain at least one number and one uppercase letter.';
        }
        if (!isset($_POST["action"])) {
            $errors = array();
            if (isset($error)) {
                $errors['password'] = $error;
            }
            echo json_encode($errors);
            exit ;
        }
        if (isset($error)) {
            return $error;
        }
    }

    public function createUser($data) {


  
    }

 





    //-----------

    public function checkLogin() {
        $errors = array();
        $data = array();

        if (empty($_POST['username']) && $_POST['username'] !== '0') {
            $errors['username'] = 'Username is required.';
        }
        if (empty($_POST['password']) && $_POST['password'] !== '0') {
            $errors['password'] = 'Password is required.';
        }
        if (!empty($errors)) {
            $data['code'] = 400;
            $data['errors'] = $errors;
        }
        else if (!isset($_POST["action"]) || $_POST["action"] !== "login") {
            $data['code'] = 401;
            $data['message'] = 'Not authorized!';
        }
        else {
            $this->loginUser();
        }

        echo json_encode($data);
        exit ;

        //clear post data before redirect
    }

    public function loginUser() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $errors = array();
        $data = array();

        //$errors['password'] = 'Incorrect username or password.';

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

    public function forgotPassword() {
        $errors = array();
        $data = array();

        if (empty($_POST['email']) && $_POST['email'] !== '0') {
            $errors['email'] = 'Email is required.';
        }
        else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email.';
        }
        if (!empty($errors)) {
            $data['code'] = 400;
            $data['errors'] = $errors;
        }
        else if (!isset($_POST["action"]) || $_POST["action"] !== "sendResetemail") {
            $data['code'] = 401;
            $data['message'] = 'Not authorized!';
        }
        else if (!$this->model->emailExists($email)) {
            $data['code'] = 409;
            $errors['email'] = 'This email is not linked to any account.';
            $data['errors'] = $errors;
        }
        else {
            $data['code'] = 200;
            $data['message'] = 'Success!';
        }

        echo json_encode($data);
        exit ;
    }



    public function viewLogin() {
        require_once __DIR__ . '/../views/pages/login.php';
    }

    public function viewForgotpassword() {
        require_once __DIR__ . '/../views/pages/forgotpassword.php';
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
        header("Location: " . URL . $url);
    }
}