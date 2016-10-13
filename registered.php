<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once './DBconnect.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
    </head>
    <body>
        <div class="container">
            <h3>User with username <?php echo $_SESSION['user']; ?> created</h3>
            <button class="btn" onclick="location.href = 'homepage.php';">Login</button>
        </div>
    </body>
</html>
