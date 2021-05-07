<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not premitted");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <title><?=TITLE?></title>
        <link rel="stylesheet" href="<?=URL?>/app/assets/css/style.css">
        <!--
        <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css">
        -->
    </head>
    <body>
        <!--header/footer vertical placement-->
        <div class="flex flex-col justify-between min-h-screen w-full max-w-screen-lg mx-auto">
            <!--header spacing and styling-->
            <header id="header" class="h-16 flex justify-center fixed top-0 left-0 right-0 z-50 blur shadow header-visible">
                <section class="w-full max-w-screen-lg flex justify-between items-center mx-4">
                    <section class="flex items-center">
                        <a href="<?=URL?>/index.php" class="flex flex-row items-center text-gray-800 text-2xl">
                            <h3 class="m-0">Camagru</h3>
                        </a>
                        <button id="open-modal" class="animatedCursor"></button>
                    </section>
                    <?php if (isset($_SESSION['username'])) { ?>
                    <section class="flex items-center">
                        <a href="<?=URL?>/index.php?page=upload">
                            <button class="mx-2 text-gray-800">Upload</button>
                        </a>
                        <a href="<?=URL?>/index.php?page=profile">
                            <button class="mx-2 text-gray-800">Profile</button>
                        </a>
                        <a href="<?=URL?>/index.php?page=logout">
                            <button class="mx-2 text-gray-800">Logout</button>
                        </a>
                    </section>
                    <?php } else { ?>
                    <section class="flex items-center">
                    <a href="<?=URL?>/index.php?page=gallery">
                        <button class="mx-2 text-gray-800">Gallery</button>
                    </a>
                    <a href="<?=URL?>/index.php?page=login">
                        <button class="mx-2 text-gray-800">Login</button>
                    </a>
                    <a href="<?=URL?>/index.php?page=signup">
                        <button class="mx-2 text-gray-800">Signup</button>
                    </a>
                    </section>
                    <?php } ?>
                </section>
            </header>
            <div id="modal-container" class="modal-container fadeIn">
                <div id="modal-content" class="modal-content flex flex-col justify-center mx-auto my-2 p-4 px-6 bg-white rounded shadow slideDown">
                    <h1 class="text-3xl text-center mb-4" id="flash-title"></h1>
                    <p class="modal-message text-center" id="flash-text"></p>
                    <button id="close-modal" class="mx-auto rounded">close me</button>
                </div>
            </div>
            <script type="text/javascript" src="<?=URL?>/app/assets/js/header.js"></script>
            <!--margins for page view main content-->
            <main class="mt-20 mb-4">