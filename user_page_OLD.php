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
        <title></title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
    </head>
    <body>
        <div class="container">
            <button onclick="location.href = 'logout.php';" class="btn">Logout</button>
            <h3>Profile page of user <?php echo $_SESSION['user']; ?></h3>

            <?php
            $user = "'" . $_SESSION['user'] . "'";

            $sql = "SELECT first_name, last_name, username, password, town, email FROM user WHERE username = $user";

            $rs = $mysqli->query($sql);

            if ($rs->num_rows === 0) {
                echo "<br><br>No results found!";
            } else {
                ?>
                <p>User data:</p>
                <form method="post">
                    <?php
                    while ($row = $rs->fetch_assoc()) {
                        ?>
                        First name: <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>">
                        <br>
                        Last name: <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>">
                        <br>
                        Username: <?php echo $row['username']; ?>
                        <br>
                        Password: <input type="password" name="password" value="<?php echo $row['password']; ?>">
                        <br>
                        Town: <input type="text" name="town" value="<?php echo $row['town']; ?>">
                        <br>  
                        E-mail: <input type="text" name="email" value="<?php echo $row['email']; ?>">
                        <br>
                        <?php
                    }
                }
                ?>
                <input type="submit" class="btn" name="save_changes" value="Save changes">
            </form>
            <?php
            if (isset($_POST['save_changes'])) {
                try {
                    $id_result = $mysqli->query("SELECT id FROM user WHERE username = $user");
                    if ($id_result->num_rows === 0) {
                        echo "<p>>No results found!</p>";
                    } else {

                        while ($row = $id_result->fetch_assoc()) {
                            $user_id = "'" . $row['id'] . "'";
                        }
                    }

                    if (empty($_POST['first_name'])) {
                        throw new Exception("<p>Please, fill in all the fields!</p>");
                    } else {
                        $first_name_input = htmlentities($_POST['first_name']);
                    }

                    if (empty($_POST['last_name'])) {
                        throw new Exception("<p>Please, fill in all the fields!</p>");
                    } else {
                        $last_name_input = htmlentities($_POST['last_name']);
                    }

                    if (empty($_POST['password'])) {
                        throw new Exception("<p>Please, fill in all the fields!</p>");
                    } elseif (strlen($_POST['password']) < 4) {
                        throw new Exception("<p>Password should contain at least 4 characters!</p>");
                    } else {
                        $password_input = htmlentities($_POST['password']);
                    }

                    if (empty($_POST['town'])) {
                        throw new Exception("<p>Please, fill in all the fields!</p>");
                    } else {
                        $town_input = htmlentities($_POST['town']);
                    }


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
                            while ($row = $result->fetch_assoc()) {
                                $email_from_db = $row['email'];
                                if ($email_from_db === $_POST['email']) {
                                    $email_input = htmlentities($_POST['email']);
                                } else {
                                    throw new Exception("<p>There is a user with the same e-mail!</p>");
                                }
                            }
                        }
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }

                if (!empty($first_name_input) && !empty($last_name_input) && !empty($password_input) && !empty($town_input) && !empty($email_input)) {
                    $first_name = "'$first_name_input'";
                    $last_name = "'$last_name_input'";
                    $password = "'$password_input'";
                    $town = "'$town_input'";
                    $title = "'$email_input'";

                    $sql = "UPDATE user SET first_name = $first_name, last_name = $last_name, password = $password, town = $town, email = $title WHERE id = $user_id";

                    if ($mysqli->query($sql) === false) {
                        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
                    } else {
                        header("Refresh:0");
                        ?>
                        <script>
                            alert("Your changes have been saved.");
                        </script>
                        <?php
                    }
                }
            } else {
                
            }
            ?>
        </div>
    </body>
</html>
