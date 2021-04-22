<?php

define('Restricted', TRUE);

$title = 'Camagru';

require_once __DIR__ . '/app/views/components/header.php';

//require controllers

if (isset($_GET["page"])) {
    if ($_GET["page"] === "gallery") {
        require_once __DIR__ . '/app/views/pages/gallery.php';
    }
    else if ($_GET["page"] === "login") {
        require_once __DIR__ . '/app/views/pages/login.php';
    }
    else if ($_GET["page"] === "signup") {
        require_once __DIR__ . '/app/views/pages/signup.php';
    }
    else {
        require_once __DIR__ . '/app/views/pages/gallery.php';
    }
}

//call to functions in controllers to generate correct view/page

require_once __DIR__ . '/app/views/components/footer.php';