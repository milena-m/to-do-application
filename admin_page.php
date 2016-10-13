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
            <h3>Logged user with email: <?php echo $_SESSION['email']; ?></h3> 
            <?php
            
            $res = $mysqli->query("SELECT id, email FROM user WHERE role = 'user'");
            $row_cnt = $res->num_rows;
            if ($row_cnt !== 0) {
                ?>
                <table>
                    <th>Users of To Do Application</th>
                    <th>Options</th>
                    <?php
                    while ($row = $res->fetch_assoc()) {
                        $email = $row['email'];
                        $user_id = $row['id'];
                        ?>  
                        <tr>
                            <td><?php echo $email; ?></td>
                            <td>
                                <form method="post" action="view_user_lists.php">
                                    <input type ="submit" name="view_lists" value="View lists" class="btn">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                </form>
                            </td>
                        </tr>                    

                        <?php
                    }
                    ?>
                </table>
                <?php
            } else {
                echo "No users to show.";
            }
            ?>
        </div>
    </body>
</html>
