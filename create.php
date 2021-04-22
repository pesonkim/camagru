<?php

require './config/database.php';

if ($_POST["username"] && $_POST["password"] && $_POST["email"] && $_POST["create"] == "Create new account")
{
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        
        $username = $_POST["username"];
        $password = hash("sha256", $_POST["username"]);
        $email = $_POST["email"];
    
        $stmt = $db->prepare("INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')");
        $stmt->execute();
        echo "Created user '" . $username . "'" . PHP_EOL;

    } catch (PDOException $e) {
        die ("Database error: " . $e->getMessage() . PHP_EOL);
    }

    try {
        $stmt = $db->query("SELECT * FROM users");

        print_r($stmt);

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['username'];
}
    } catch (PDOException $e) {
        die ("Database error: " . $e->getMessage() . PHP_EOL);
    }
    
}
else
    echo "error\n";

?>
