<?php

define('Restricted', TRUE);

$title = "Camagru";
$pages = array(
    "home",
    "gallery",
    "login",
    "signup"
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

//call to functions in controllers to generate correct view/page

//this is temp redirect
if (isset($view)) {
    if ($view === "home") {
        require_once __DIR__ . '/app/views/pages/gallery.php';
    }
    else {
        require_once __DIR__ . '/app/views/pages/' . $view . '.php';
    }   
}
else {
    require_once __DIR__ . '/app/views/pages/gallery.php';
}

require_once __DIR__ . '/app/views/components/footer.php';