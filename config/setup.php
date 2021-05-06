<?php

require_once 'database.php';

try {
    $db = new PDO('mysql:host='.$DB_HOST, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS `$DB_NAME`";
    $db->exec($sql);
    echo "Created database '" . $DB_NAME . "'" . PHP_EOL;

    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE IF NOT EXISTS users(
        user_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username varchar(50) NOT NULL,
        email varchar(100) NOT NULL,
        password varchar(255) NOT NULL,
        verify_hash varchar(50) NOT NULL,
        verify_email TINYINT(1) NOT NULL,
        notify_email TINYINT(1) NOT NULL DEFAULT 1
    )";
    $db->exec($sql);
    echo "Created table 'users'" . PHP_EOL;

    /*
    $sql = "CREATE TABLE IF NOT EXISTS images(
        img_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        img_name varchar(50),
        user_id int NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    )";
    $db->exec($sql);
    echo "Created table 'images'" . PHP_EOL;
    
    $sql = "CREATE TABLE IF NOT EXISTS comments(
        comment_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        comment_text varchar(255),
        img_id int NOT NULL,
        user_id int NOT NULL,
        FOREIGN KEY (img_id) REFERENCES images(img_id),
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    )";
    $db->exec($sql);
    echo "Created table 'comments'" . PHP_EOL;

    $sql = "CREATE TABLE IF NOT EXISTS likes(
        like_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
        img_id int NOT NULL,
        user_id int NOT NULL,
        FOREIGN KEY (img_id) REFERENCES images(img_id),
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    )";
    $db->exec($sql);
    echo "Created table 'likes'" . PHP_EOL;
    */

} catch (PDOException $e) {
    die ("Database error: " . $e->getMessage() . PHP_EOL);
}
