<?php

session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <title>Camagru</title>
        <link rel="stylesheet" href="public/css/style.css">
    </head>
    <body>
        <form action="create.php" method="POST">
            Username: <input type="text" placeholder="Username" name="username" value="" >
            <br />
            Password: <input type="text" placeholder="Password" name="password" value="" >
            <br />
            Email: <input type="text" placeholder="Email" name="email" value="" >
            <br />
            <input type="submit" name="create" value="Create new account" />
        </form>
    </body>
</html>