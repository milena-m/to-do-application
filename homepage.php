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
        <title>Home page</title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
    </head>
    <body>
        <div class="container">
            <h3>To Do Application</h3>
            <form method="post">
                E-mail: <input type="text" name="email"><br/>
                Password: <input type="password" name="password"><br/><br/>
                <input type="submit" class="btn" value="Login" name="login">
                <input type="submit" class="btn" value="Register" name="register_user">
            </form>
            <?php
            if (isset($_POST['register_user'])) {
                header('Location: register_user.php');
            }

            if (isset($_POST['login'])) {
                $email_input = htmlentities($_POST['email']);
                $password_input = htmlentities($_POST['password']);

                $email = "'$email_input'";
                $password = "'$password_input'";

                $sql_user = "SELECT id, email, password, role FROM user WHERE email = $email AND password = $password";

                $rs_user = $mysqli->query($sql_user);

                if ($rs_user->num_rows !== 0) {
                    if ($mysqli->query($sql_user) === false) {
                        trigger_error('Wrong SQL: ' . $sql_user . ' Error: ' . $mysqli->error, E_USER_ERROR);
                    } else {
                        while ($row = $rs_user->fetch_assoc()) {
                            echo " Logged user with e-mail" . $row['name'];
                            $role = $row['role'];
                            $user_id = $row['id'];
                            $email = $row['email'];

                            if ($role == 'user') {
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['email'] = $email;
                                header('Location: user_page.php');
                            }
                            if ($role == 'admin') {
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['email'] = $email;
                                header('Location: admin_page.php');
                            }
                        }
                    }
                } else {
                    echo "<p>Wrong username/password</p>";
                }
            }
            ?>
        </div>
    </body>
</html>
