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
            <button onclick="location.href = 'admin_page.php';" class="btn">Back to admin page</button>
            <br><br>
            <?php
            if (isset($_POST['archive_list'])) {
                $list_id = $_POST['list_id'];
                $sql = "UPDATE list_of_tasks SET archived = 'archived' WHERE id = $list_id";
                if ($mysqli->query($sql) === false) {
                    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
                } else {
                    echo "The list has been archived";
                }
            }

            if (isset($_POST['view_lists'])) {
                $user_id = $_POST['user_id'];

                $mysqli->real_query("SELECT id, title, archived FROM list_of_tasks WHERE user_id = $user_id");
                $res = $mysqli->use_result();
                ?>
                <table>
                    <?php
                    while ($row = $res->fetch_assoc()) {
                        $list_id = $row['id'];
                        $title = $row['title'];
                        $archived = $row['archived'];
                        if ($archived == 'awaiting archiving') {
                            ?>  
                            <tr>
                                <td class="completedOrArchived"> <?php echo $title; ?> </td>
                                <td colspan="2"> 
                                    <form method="post">
                                        <input type ="submit" name="archive_list" value="Confirm archiving" class="btn">
                                        <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
                                    </form>
                                </td>
                            </tr>
                            <?php
                        } elseif ($archived == 'archived') {
                            ?>  
                            <tr>
                                <td class="completedOrArchived"> <?php echo $title; ?> </td>
                                <td class="completedOrArchived" colspan="2">Archived</td>      
                            </tr>
                            <?php
                        } else {
                            ?>  
                            <tr id="lists">
                                <td> <?php echo $title; ?> </td>
                                <td colspan="3">Active</td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </table>

        </div>
    </body>
</html>
