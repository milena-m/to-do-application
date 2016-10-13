<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once './DBconnect.php';
include_once 'User.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register user</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
    </head>
    <body>
        <div class="container">
            <h2>User registration page</h2>
            <form method="POST">
                E-mail <input type="text" name="email"><br>
                Password <input type="password" name="password"><br>                                            
                <input type="submit" class="btn" value="Create Profile" name="create_profile">       
            </form>
            <?php
            if (isset($_POST['create_profile'])) {
                try {

                    if (empty($_POST['email'])) {
                        throw new Exception("<p>Please, fill in all the fields!</p>");
                    } else {
                        $title = "'" . ($_POST['email']) . "'";
                        $result = $mysqli->query("SELECT email FROM user WHERE email = $title");
                        $row_cnt = $result->num_rows;
                        if ($row_cnt === 0) {
                            $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

                            if (preg_match($pattern, $_POST['email']) === 1) {
                                $email_input = htmlentities($_POST['email']);
                            } else {
                                throw new Exception("<p>Invalid e-mail!</p>");
                            }
                        } else {
                            throw new Exception("<p>There is a user with the same e-mail!</p>");
                        }
                    }

                    if (empty($_POST['password'])) {
                        throw new Exception("<p>Please, fill in all the fields!</p>");
                    } elseif (strlen($_POST['password']) < 4) {
                        throw new Exception("<p>Password should contain at least 4 characters!</p>");
                    } else {
                        $password_input = htmlentities($_POST['password']);
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                if (!empty($email_input) && !empty($password_input)) {
                    $title = "'$email_input'";
                    $password = "'$password_input'";
                    
                    $role = "'user'";

                    $user = new User($title, $password, $role);

                    $sql = "SELECT id FROM user WHERE email = $title";

                    $rs = $mysqli->query($sql);

                    if ($rs->num_rows === 0) {
                        $user->writeToDB($title, $password, $role);
                    } else {
                        echo "<p>User with email $title already exists!</p>";
                    }
                }
            } else {
                
            }
            ?>
            <button class="btn" onclick="location.href = 'homepage.php';">Home page</button>
        </div>
    </body>
