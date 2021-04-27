<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <title><?=$title?></title>
        <link rel="stylesheet" href="public/css/style.css">
        <!--
        <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css">
        -->
    </head>
    <body>
        <!--header/footer vertical placement-->
        <div class="flex flex-col justify-between min-h-screen w-full max-w-screen-lg mx-auto">
            <!--header spacing and styling-->
            <header class="h-16 flex justify-center fixed top-0 left-0 right-0 z-50 blur shadow">
                <section class="w-full max-w-screen-lg flex justify-between items-center mx-4">
                    <section class="flex items-center">
                        <a href="index.php?page=home" class="flex flex-row items-center text-gray-800 text-2xl">
                            <h3 class="m-0">Camagru</h3>
                            <div class="animatedCursor"></div>
                        </a>
                    </section>
                    <section class="flex items-center">
                        <a href="index.php?page=gallery">
                            <button class="mx-2 text-gray-800">Gallery</button>
                        </a>
                        <a href="index.php?page=login">
                            <button class="mx-2 text-gray-800">Login</button>
                        </a>
                        <a href="index.php?page=signup">
                            <button class="mx-2 text-gray-800">Signup</button>
                        </a>
                    </section>
                </section>
            </header>
            <!--margins for page view main content-->
            <main class="mt-20 mb-4">