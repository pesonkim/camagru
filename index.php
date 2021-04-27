<?php

$title = "Camagru";
$pages = array(
    "home",
    "gallery",
    "login",
    "signup",
    "account"
);

if (isset($_GET["page"]) && in_array($_GET["page"], $pages)) {
    $view = $_GET["page"];
    $title .= " - " . ucfirst($view);
}
elseif (isset($_GET["page"]) && !in_array($_GET["page"], $pages)) {
    $view = "404";
    $title .= " - " . $view;
}

require_once __DIR__ . '/app/views/components/header.php';

require_once __DIR__ . '/app/controllers/UserController.php';

var_dump($_SERVER);

//echo $requestUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//echo $requestString = substr($requestUrl, strlen($baseUrl));

//print_r($urlParams = explode('/', $requestString));

//switch case and controller method calls here

switch ($page) {
    case "asd": {
        $controller;
        break ;
    }
}

require_once __DIR__ . '/app/views/components/footer.php';