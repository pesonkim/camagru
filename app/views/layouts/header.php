<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <title>
            <?php if (isset($_SESSION['username'])) { ?>
            <?=TITLE.' - '.$_SESSION['username']?>
            <?php } else { ?>
            <?=TITLE?>
            <?php }?>
        </title>
        <link rel="stylesheet" href="<?=URL?>/app/assets/css/style.css">
    </head>
    <body>
        <!--header/footer vertical placement-->
        <div class="flex flex-col justify-between min-h-screen w-full max-w-screen-lg mx-auto">
            <!--header spacing and styling-->
            <header id="header" class="h-16 flex justify-center fixed top-0 left-0 right-0 z-50 blur shadow header-visible">
                <section class="w-full max-w-screen-lg flex justify-between items-center px-2">
                    <section class="flex items-center">
                        <a href="<?=URL?>/index.php" class="flex flex-row items-center text-2xl">
                            <h3 class="m-0">Camagru</h3>
                        </a>
                        <a href="<?=URL?>/index.php?page=example" class="animatedCursor"></a>
                    </section>
                    <?php if (isset($_SESSION['username'])) { ?>
                    <section class="flex items-center">
                        <a href="<?=URL?>/index.php?page=upload">
                            <button class="mr-2">My posts</button>
                        </a>
                        <a class="verticalLine" href="<?=URL?>/index.php?page=profile">
                            <button id="profileSm" class="mx-2">Profile</button>
                            <button id="profileLg" class="mx-2">Profile (<?=$_SESSION['username']?>)</button>
                        </a>
                        <a href="<?=URL?>/index.php?page=logout">
                            <button class="ml-2">Logout</button>
                        </a>
                    </section>
                    <?php } else { ?>
                    <section class="flex items-center">
                        <a href="<?=URL?>/index.php?page=gallery">
                            <button class="mr-2">Gallery</button>
                        </a>
                        <a class="verticalLine" href="<?=URL?>/index.php?page=login">
                            <button class="mx-2">Login</button>
                        </a>
                        <a href="<?=URL?>/index.php?page=signup">
                            <button class="ml-2">Signup</button>
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