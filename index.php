<?php

$title = "Camagru";

require_once __DIR__ . '/app/controllers/UserController.php';

if (isset($_GET['UserController'])) {
    if (isset($_GET['method'])) {
        $ctrl = new UserController();
        $method = $_GET['method'];
        if (method_exists($ctrl, $method))
            $ctrl->$method();
    }
}

require_once __DIR__ . '/app/views/layouts/header.php';

$page = $_GET['page'];
switch ($page) {
    case "login": {
        $ctrl = new UserController();
        $ctrl->viewLogin();
        break ;
    }
    case "signup": {
        $ctrl = new UserController();
        $ctrl->viewSignup();
        break ;
    }
    case "account": {
        $ctrl = new UserController();
        $ctrl->viewAccount();
        break ;
    }
    case "gallery": {
        $ctrl = new UserController();
        $ctrl->viewGallery();
        break ;
    }
    default: {
        $ctrl = new UserController();
        $ctrl->viewGallery();
        break ;
    }
}

require_once __DIR__ . '/app/views/layouts/footer.php';