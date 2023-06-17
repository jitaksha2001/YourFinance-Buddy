<?php

session_start();
session_destroy();

?>

<!DOCTYPE html>

<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style-logout.css">
    <title>Logout</title>
</head>
<body>

    <div class="container">
        <div class="logout-box">
            <h1>You have successfully logged out!</h1>
            <a href="login.php">Click here to return to login page</a>
        </div>
    </div>

</body>
</html>