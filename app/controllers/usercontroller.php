<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}

require_once DIRPATH . '/app/models/UserModel.php';

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    //check if request was submitted by ajax
    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    //called after submitting signup form
    public function signupUser() {
        $data = array();
        $errors = array();

        //check if form was correctly submitted, else return request as unauthorized
        if ($this->isAjax()) {
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
                else if ($this->model->usernameExists($_POST['username'])) {
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
                    $this->createUser();
                }
            }
            else {
                $data['code'] = 401;
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }


    //validate signup username, called with ajax after input field loses focus or entire form is submitted
    public function validateUsernameFormat() {
        if ($this->isAjax()) {
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
            else if ($this->model->usernameExists($_POST['username'])) {
                $error = 'This username is already taken.';
            }
            if (isset($error)) {
                return $error;
            }
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //validate signup email, called with ajax after input field loses focus or entire form is submitted
    public function validateEmailFormat() {
        if ($this->isAjax()) {
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
            else if ($this->model->emailExists($_POST['email'])) {
                $error = 'An account with this email address already exists.';
            }
            if (isset($error)) {
                return $error;
            }
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //validate signup password, called with ajax after input field loses focus or entire form is submitted
    public function validatePasswordFormat() {
        if ($this->isAjax()) {
            if (empty($_POST['password'])) {
                $error = 'Please enter a password.';
            }
            else if (strlen($_POST['password']) <  6) {
                $error = 'Password must be at least 6 characters long.';
            }
            else if (!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{6,}$/', $_POST['password'])) {
                $error = 'Password must contain at least one lowercase and uppercase letter, and a number.';
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
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //prepare data array and call UserModel to create and insert new user
    public function createUser() {
        $data = array();

        if ($this->isAjax()) {
            $data['username'] = $_POST['username'];
            $data['email'] = $_POST['email'];
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $data['token'] = bin2hex(random_bytes(32));
            $data['created_at'] = date('Y-m-d H:i:s');
    
            $this->model->createUser($data);
            $user = $this->model->getUserData($data['username']);
            $subject = 'Welcome to Camagru!';
            $verifylink = URL . '/index.php?page=verify&id='.$user['id_user'].'&token='.$user['token'];
            $body = "

            Welcome to Camagru!
            
            Your account '".$user['username']."' was successfully created and almost ready to use.
            Before you can log in, we still ask that you verify your email address:
            ".$user['email']."
            
            This will let you receive notifications and password resets from Camagru.
            
            Please follow this link or paste it in your browser to verify your email address:
            ".$verifylink."

            -Camagru
            ";
            mail($user['email'], $subject, $body);
            $data['code'] = 200;
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //handle email verification and update account status
    public function verifyEmail() {
        $id = $_GET['id'];
        $token = $_GET['token'];
        
        if (!empty($id) && !empty($token)) {
            $hash = $this->model->getTokenById($id);
            if ($token === $hash) {
                //update verified status in UserModel
                $this->model->updateVerified($id);
                //destroy currently saved token to expire verify email
                $newToken = bin2hex(random_bytes(32));
                $this->model->updateToken($id, $newToken);
                $this->redirect('/index.php?verify=success');
            }
            else {
                $this->redirect('/index.php?token=false');
            }
        }
        else {
            $this->redirect('/index.php?token=false');
        }
    }

    //called after submitting login form
    public function loginUser() {
        $data = array();
        $errors = array();

        //check if form was correctly submitted, else return request as unauthorized
        if ($this->isAjax()) {
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
        else {
            $this->redirect('/index.php?auth=false');
        }
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
        
        if ($this->isAjax()) {
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
                    $user = $this->model->getUserDataByEmail($_POST['email']);
                    if ($user['is_verified'] === '1') {
                        $subject = 'Reset your Camagru password';
                        $verifylink = URL . '/index.php?page=resetpassword&id='.$user['id_user'].'&token='.$user['token'];
                        $body = "
            
                        Hello,
                        
                        Your account '".$user['username']."' recently requested to reset your Camagru password.
                        Please follow this link or paste it in your browser to set a new password:
                    
                        ".$verifylink."
                        
                        If you didn't request a password reset, you can ignore this email.
    
                        -Camagru
                        ";
                        mail($user['email'], $subject, $body);
                        $data['code'] = 200;
                    }
                    else {
                        $data['code'] = 400;
                        $errors['verify'] = 'Please verify your email address first to receive reset instructions.';
                        $data['errors'] = $errors;
                    }
                }
            }
            else {
                $data['code'] = 401;
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //display reset password form if authorized
    public function resetForm() {
        $id = $_GET['id'];
        $token = $_GET['token'];
        
        if (!empty($id) && !empty($token)) {
            $hash = $this->model->getTokenById($id);
            if ($token === $hash) {
                require_once DIRPATH .  '/app/views/pages/resetpassword.php';
            }
            else {
                $this->redirect('/index.php?token=false');
            }
        }
        else {
            $this->redirect('/index.php?token=false');
        }
    }

    //handle password reset form submit
    public function resetPassword() {
        $errors = array();
        $data = array();
        
        if ($this->isAjax()) {
            if ((isset($_POST["action"]) && $_POST["action"] === "resetPassword") 
                && (!empty($_POST['id']) && !empty($_POST['token']))) {
                if ($this->validatePasswordFormat()) {
                    $errors['password'] = $this->validatePasswordFormat();
                }
                if (!empty($errors)) {
                    $data['code'] = 400;
                    $data['errors'] = $errors;
                }
                //check against current password
                else if ($this->model->authUserByIdToken($_POST['id'], $_POST['token'], $_POST['password'])) {
                    $errors['password'] = 'New password is the same as current one. Please choose another one or try logging in instead.';
                    $data['code'] = 400;
                    $data['errors'] = $errors;
                }
                else {
                    $passwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $this->model->updatePassword($_POST['id'], $passwd);
                    //destroy currently saved token to expire reset email
                    $newToken = bin2hex(random_bytes(32));
                    $this->model->updateToken($_POST['id'], $newToken);
                    $data['code'] = 200;
                }
            }
            else {
                $data['code'] = 401;
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //fetch user notification preference
    public function getNotifyPref() {
        $data = array();
        if ($this->isAjax()) {
            if (isset($_POST["action"]) && $_POST["action"] === "getNotifyPref" && isset($_SESSION["id_user"])) {
                $data['pref'] = $this->model->getNotifyPrefById($_SESSION["id_user"]);
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //update user notification preference
    public function updateNotifyPref() {
        if ($this->isAjax()) {
            if (isset($_POST["action"]) && $_POST["action"] === "updateNotifyPref" && isset($_SESSION["id_user"])
                && isset($_POST["pref"])) {
                $this->model->updateNotifyPref($_SESSION["id_user"],$_POST["pref"]);
            }
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //handle username and/or email updates
    public function updateUserInfo() {
        $data = array();
        $error = array();
        if ($this->isAjax()) {
            if (isset($_POST["action"]) && $_POST["action"] === "update" && isset($_SESSION["id_user"])) {
                if (!empty($_POST['username'])) {
                    if ($this->validateUsernameFormat()) {
                        $errors['username'] = $this->validateUsernameFormat();
                    }
                }
                if (!empty($_POST['email'])) {
                    if ($this->validateEmailFormat()) {
                        $errors['email'] = $this->validateEmailFormat();
                    }
                }
                //return syntax and format errors
                if (!empty($errors)) {
                    $data['code'] = 400;
                    $data['errors'] = $errors;
                }
                else if ($this->model->usernameExists($_POST['username'])) {
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
                //update username and/or email after error check pass
                else {
                    if (!empty($_POST['username'])) {
                        $this->model->updateUsername($_SESSION["id_user"], $_POST['username']);
                        $_SESSION['username'] = $_POST['username'];
                        $data['code'] = 200;
                    }
                    if (!empty($_POST['email'])) {
                        $this->model->updateEmail($_SESSION["id_user"], $_POST['email']);
                        $_SESSION['email'] = $_POST['email'];
                        $data['code'] = 200;
                    }
                }
            }
            else {
                $data['code'] = 401;
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //update user password
    public function updatePassword() {
        $errors = array();
        $data = array();
        
        if ($this->isAjax()) {
            if ((isset($_POST["action"]) && $_POST["action"] === "updatePassword")
            && (!empty($_SESSION['id_user']))) {
                if (empty($_POST['oldPassword'])) {
                    $errors['oldpassword'] = 'Please enter your current password.';
                }
                //compare 'old' password against database hash 
                else if (!$this->model->authUserByIdPassword($_SESSION['id_user'],$_POST['oldPassword'])) {
                    $errors['oldpassword'] = 'Your password was incorrect.';
                    $data['errors'] = $errors;
                }
                if (empty($_POST['newPassword'])) {
                    $errors['newpassword'] = 'Please enter a new password.';
                }
                else if (strlen($_POST['newPassword']) <  6) {
                    $errors['newpassword'] = 'Password must be at least 6 characters long.';
                }
                else if (!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{6,}$/', $_POST['newPassword'])) {
                    $errors['newpassword'] = 'Password must contain at least one lowercase and uppercase letter, and a number.';
                }
                if (!empty($errors)) {
                    $data['code'] = 400;
                    $data['errors'] = $errors;
                }
                //test if new !== old
                else if ($_POST['newPassword'] === $_POST['oldPassword']) {
                    $errors['newpassword'] = 'New password cannot be the same as current one.';
                    $data['code'] = 400;
                    $data['errors'] = $errors;
                }
                //finally hash new password and update to database 
                else {
                    $passwd = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
                    $this->model->updatePassword($_SESSION['id_user'], $passwd);
                    $data['code'] = 200;
                }
            }
            else {
                $data['code'] = 401;
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //ajax check if user is logged in
    public function isLoggedIn() {
        $data = array();

        //check if form was correctly submitted, else return request as unauthorized
        if ($this->isAjax()) {
            if ($_POST["action"] === "isLoggedIn" && 
            (isset($_SESSION['id_user']) && isset($_SESSION['username']))) {
                $data['user'] = '1';
            }
            else {
                $data['user'] = '0';
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    public function authUser() {
        $data = array();

        if ($this->isAjax()) {
            if ($_POST["action"] === "authUser" && 
            (isset($_SESSION['id_user']) && isset($_SESSION['username']))
            && $_SESSION['username'] === ADMIN) {
                $data['user'] = '1';
            }
            else {
                $data['user'] = '0';
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //delete user data
    public function deleteUser() {
        $data = array();
        $errors = array();

        //check if form was correctly submitted, else return request as unauthorized
        if ($this->isAjax()) {
            if (isset($_POST["action"]) && $_POST["action"] === "delete") {
                if (empty($_POST['username'])) {
                    $errors['username'] = 'Username cannot be empty.';
                }
                if (empty($_POST['password'])) {
                    $errors['password'] = 'Password cannot be empty.';
                }
                //return empty fields
                if (!empty($errors)) {
                    $data['code'] = 400;
                    $data['errors'] = $errors;
                }
                //compare login input to hashed password in database 
                else if ($this->model->loginUser($_POST['username'],$_POST['password'])) {
                    //call whatever to nuke user account at this point
                    $data['code'] = 200;
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
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    public function viewLogin() {
        if (!isset($_SESSION['username']))
            require_once DIRPATH .  '/app/views/pages/login.php';
        else
            $this->redirect('/index.php?login=true');
    }

    public function viewResetPassword() {
        if (!isset($_SESSION['username']))
            $this->resetForm();
        else
            $this->redirect('/index.php?login=true');
    }

    public function viewForgotPassword() {
        if (!isset($_SESSION['username']))
            require_once DIRPATH .  '/app/views/pages/forgotpassword.php';
        else
            $this->redirect('/index.php?login=true');
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

    public function viewProfile() {
        if (isset($_SESSION['username']))
            require_once DIRPATH .  '/app/views/pages/profile.php';
        else
            $this->pleaseLogin();
    }

    public function viewUpload() {
        if (isset($_SESSION['username']))
            require_once DIRPATH .  '/app/views/pages/upload.php';
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