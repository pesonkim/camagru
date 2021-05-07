<?php

session_start();
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/controllers/UserController.php';
require_once __DIR__ . '/app/controllers/PostController.php';

if (isset($_GET['UserController'])) {
    if (isset($_GET['method'])) {
        $ctrl = new UserController();
        $method = $_GET['method'];
        if (method_exists($ctrl, $method))
            $ctrl->$method();
    }
}
else if (isset($_GET['PostController'])) {
    if (isset($_GET['method'])) {
        $ctrl = new PostController();
        $method = $_GET['method'];
        if (method_exists($ctrl, $method))
            $ctrl->$method();
    }
}

require_once __DIR__ . '/app/views/layouts/header.php';

$page = $_GET['page'];
switch ($page) {
    case "signup": {
        $ctrl = new UserController();
        $ctrl->viewSignup();
        break ;
    }
    case "login": {
        $ctrl = new UserController();
        $ctrl->viewLogin();
        break ;
    }
    case "logout": {
        $ctrl = new UserController();
        $ctrl->logout();
        break ;
    }
    case "forgotpassword": {
        $ctrl = new UserController();
        $ctrl->viewForgotPassword();
        break ;
    }
    case "resetpassword": {
        $ctrl = new UserController();
        $ctrl->viewResetPassword();
        break ;
    }
    case "account": {
        $ctrl = new UserController();
        $ctrl->viewAccount();
        break ;
    }
    case "gallery": {
        $ctrl = new PostController();
        $ctrl->viewGallery();
        break ;
    }
    default: {
        $ctrl = new PostController();
        $ctrl->viewGallery();
        break ;
    }
}

require_once __DIR__ . '/app/views/layouts/footer.php';