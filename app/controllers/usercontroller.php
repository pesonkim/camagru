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

    //called after submitting signup form
    public function signupUser() {
        $data = array();
        $errors = array();

        //check if form was correctly submitted, else return request as unauthorized
        if (isset($_POST["action"]) && $_POST["action"] === "signup") {
            if ($this->validateUsernameFormat()) {
                $errors['username'] = $this->validateUsernameFormat();
            }
            if ($this->validateEmailFormat()) {
                $errors['email'] = $this->validateEmailFormat();
            }
            if ($this->validatePasswordFormat()) {
                $errors['password'] = $this->validatePasswordFormat();
            }
            //return syntax and format errors
            if (!empty($errors)) {
                $data['code'] = 400;
                $data['errors'] = $errors;
            }
            else if ($this->model->usernameExists($_POST['email'])) {
                $errors['username'] = 'This username is already taken.';
            }
            else if ($this->model->emailExists($_POST['email'])) {
                $errors['email'] = 'An account with this email address already exists.';
            }
            //return conflicts if username or email is already in database
            else if (!empty($errors)) {
                $data['code'] = 409;
                $data['errors'] = $errors;
            }
            //pass post data to createUser method if no errors
            else {
                $this->createUser($data);
            }
        }
        else {
            $data['code'] = 401;
        }
        echo json_encode($data);
        exit ;
    }

    //validate signup username, called with ajax after input field loses focus or entire form is submitted
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
            else if ($this->model->usernameExists($_POST['username'])) {
                $errors['username'] = 'This username is already taken.';
            }
            echo json_encode($errors);
            exit ;
        }
        if (isset($error)) {
            return $error;
        }
    }

    //validate signup email, called with ajax after input field loses focus or entire form is submitted
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
            else if ($this->model->emailExists($_POST['email'])) {
                $errors['email'] = 'An account with this email address already exists.';
            }
            echo json_encode($errors);
            exit ;
        }
        if (isset($error)) {
            return $error;
        }
    }

    //validate signup password, called with ajax after input field loses focus or entire form is submitted
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

    //prepare data array and call UserModel to create and insert new user
    public function createUser($data) {
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $data['token'] = bin2hex(random_bytes(32));
        $data['created_at'] = date('Y-m-d H:i:s');

        $this->model->createUser($data);
        $data['code'] = 200;
        
        echo json_encode($data);
        exit ;

        //handle email
    }

    //called after submitting login form
    public function loginUser() {
        $data = array();
        $errors = array();

        //check if form was correctly submitted, else return request as unauthorized
        if (isset($_POST["action"]) && $_POST["action"] === "login") {
            if (empty($_POST['username'])) {
                $errors['username'] = 'Please enter a username.';
            }
            if (empty($_POST['password'])) {
                $errors['password'] = 'Please enter a password.';
            }
            //return empty fields
            if (!empty($errors)) {
                $data['code'] = 400;
                $data['errors'] = $errors;
            }
            //compare login input to hashed password in database 
            else if ($this->model->loginUser($_POST['username'],$_POST['password'])) {
                //fetch user data if password verify matches
                $user = $this->model->getUserData($_POST['username']);
                //set session data if account is verified
                if ($user['is_verified'] === '1') {
                    $_SESSION['id_user'] = $user['id_user'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['notify_pref'] = $user['notify_pref'];
                    $data['code'] = 200;
                }
                else {
                    $data['code'] = 400;
                    $errors['verify'] = 'Please verify your email first.';
                    $data['errors'] = $errors;
                }
            }
            //return syntax error if password verify fails
            else {
                $data['code'] = 400;
                $errors['login'] = 'Your login information was incorrect.';
                $data['errors'] = $errors;
            }
        }
        else {
            $data['code'] = 401;
        }
        echo json_encode($data);
        exit ;
    }

    //clear session variables for logged in user
    public function logout() {
        if (isset($_SESSION['id_user'])) {
            unset($_SESSION['id_user']);
        }
        if (isset($_SESSION['username'])) {
            unset($_SESSION['username']);
        }
        if (isset($_SESSION['email'])) {
            unset($_SESSION['email']);
        }
        if (isset($_SESSION['notify_pref'])) {
            unset($_SESSION['notify_pref']);
        }
        session_destroy();
        $this->redirect('/index.php?logout=success');
    }

    //send password reset email after form submission
    public function forgotPassword() {
        $errors = array();
        $data = array();
        
        if (isset($_POST["action"]) && $_POST["action"] === "sendResetEmail") {
            if (empty($_POST['email'])) {
                $errors['email'] = 'Please enter an email address.';
            }
            else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Please enter a valid email address.';
            }
            else if (!$this->model->emailExists($_POST['email'])) {
                $errors['email'] = 'This email is not linked to any account.';
            }
            if (!empty($errors)) {
                $data['code'] = 400;
                $data['errors'] = $errors;
            }
            else {
                $data['code'] = 200;
            }
        }
        else {
            $data['code'] = 401;
        }
        echo json_encode($data);
        exit ;
    }

        //handle password reset form submit
        public function resetPassword() {
            $errors = array();
            $data = array();
            
            if (isset($_POST["action"]) && $_POST["action"] === "resetPassword") {
                if ($this->validatePasswordFormat()) {
                    $errors['password'] = $this->validatePasswordFormat();
                }
                if (!empty($errors)) {
                    $data['code'] = 400;
                    $data['errors'] = $errors;
                }
                //check against current password
                else if (1) {
                    $errors['password'] = 'New password is the same as current one. Please choose another one or try logging in instead.';
                    $data['code'] = 400;
                    $data['errors'] = $errors;
                }
                else {
                    $data['code'] = 200;
                }
            }
            else {
                $data['code'] = 401;
            }
            echo json_encode($data);
            exit ;
        }

    public function viewLogin() {
        if (!isset($_SESSION['username']))
            require_once DIRPATH .  '/app/views/pages/login.php';
        else
            $this->redirect('/index.php?login=true');
    }

    public function viewForgotPassword() {
        if (!isset($_SESSION['username']))
            require_once DIRPATH .  '/app/views/pages/forgotpassword.php';
        else
            $this->redirect('/index.php?login=true');
    }

    public function viewResetPassword() {
        /*
        if (!isset($_SESSION['username']))
            require_once DIRPATH .  '/app/views/pages/forgotpassword.php';
        else
            $this->redirect('/index.php?login=true');
        */
        require_once DIRPATH .  '/app/views/pages/resetpassword.php';
    }

    public function viewSignup() {
        if (!isset($_SESSION['username']))
            require_once DIRPATH .  '/app/views/pages/signup.php';
        else
            $this->redirect('/index.php?login=true');
    }

    public function pleaseLogin() {
        $this->redirect('/index.php?login=false');
    }

    public function viewAccount() {
        if (isset($_SESSION['username']))
            require_once DIRPATH .  '/app/views/pages/account.php';
        else
            $this->pleaseLogin();
    }

    public function viewGallery() {
        require_once DIRPATH .  '/app/views/pages/gallery.php';
    }

    public function redirect($url) {
        header("Location: " . URL . $url);
    }
}