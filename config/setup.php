<?php

require_once 'database.php';

try {
    $db = new PDO('mysql:host='.$DB_HOST, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE `$DB_NAME`";
    $db->exec($sql);
    echo "Created database '" . $DB_NAME . "'" . PHP_EOL;

    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE `users`(
        `id_user` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `username` varchar(50) NOT NULL,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `verification_hash` varchar(255) NOT NULL,
        `is_verified` tinyint(1) NOT NULL DEFAULT 0,
        `notify_pref` tinyint(1) NOT NULL DEFAULT 1,
        `created_at` datetime NOT NULL
    )";
    $db->exec($sql);
    echo "Created table 'users'" . PHP_EOL;

    $sql = "CREATE TABLE `posts`(
        `id_post` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `post_title` varchar(255),
        `id_user` int NOT NULL,
        `created_at` datetime NOT NULL,
        FOREIGN KEY (`id_user`) REFERENCES users(`id_user`)
    )";
    $db->exec($sql);
    echo "Created table 'posts'" . PHP_EOL;
    
    $sql = "CREATE TABLE `comments`(
        `id_comment` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `comment` varchar(5000),
        `id_post` int NOT NULL,
        `id_user` int NOT NULL,
        `created_at` datetime NOT NULL,
        FOREIGN KEY (`id_post`) REFERENCES posts(`id_post`),
        FOREIGN KEY (`id_user`) REFERENCES users(`id_user`)
    )";
    $db->exec($sql);
    echo "Created table 'comments'" . PHP_EOL;

    $sql = "CREATE TABLE `likes`(
        `id_like` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `id_post` int NOT NULL,
        `id_user` int NOT NULL,
        `created_at` datetime NOT NULL,
        FOREIGN KEY (`id_post`) REFERENCES posts(`id_post`),
        FOREIGN KEY (`id_user`) REFERENCES users(`id_user`)
    )";
    $db->exec($sql);
    echo "Created table 'likes'" . PHP_EOL;

} catch (PDOException $e) {
    die ("Database error: " . $e->getMessage() . PHP_EOL);
}
