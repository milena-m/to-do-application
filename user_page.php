<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once './DBconnect.php';
include_once 'List_of_tasks.php';
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

            <form name="list_title_form"  method="POST">
                <textarea id="title" name="list_title" rows="1" cols="30"></textarea>                                          
                <input type="submit" name="add_list" class="btn" value="Add list">       
            </form>
            <br>
            <?php
            $user_id = $_SESSION['user_id'];            

            if (isset($_POST['archive_list'])) {
                $list_id = $_POST['list_id'];
                $result = $mysqli->query("SELECT id FROM task WHERE list_id = $list_id");
                $row_cnt = $result->num_rows;
                if ($row_cnt === 0) {
                    ?>
                    <script>alert('A list should have at least one task to be archived!');</script>
                    <?php
                } else {
                    $sql = "UPDATE list_of_tasks SET archived = 'awaiting archiving' WHERE id = $list_id";
                    if ($mysqli->query($sql) === false) {
                        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
                        
                    } 
                }
            }

            if (isset($_POST['delete_list'])) {
                $list_id = $_POST['list_id'];
                $sql = "DELETE FROM list_of_tasks WHERE id = $list_id";
                if ($mysqli->query($sql) === false) {
                    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
                }
            }

            if (isset($_POST['add_list'])) {
                try {
                    if (empty($_POST['list_title']) || strlen($_POST['list_title']) < 3 || strlen($_POST['list_title']) > 30) {
                        throw new Exception("<p>Please, enter a title between 3 and 30 characters!</p>");
                    } else {
                        $list_title = "'" . ($_POST['list_title']) . "'";
                        $result = $mysqli->query("SELECT title FROM list_of_tasks WHERE title = $list_title");
                        $row_cnt = $result->num_rows;
                        if ($row_cnt === 0) {
                            $list_title_input = htmlentities($_POST['list_title']);
                        } else {
                            throw new Exception("<p>There is a list with the same title!</p>");
                        }
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                if (!empty($list_title_input)) {
                    $list_title = "'$list_title_input'";
                    $list = new List_of_tasks($list_title, $user_id);
                    $sql = "SELECT id FROM list_of_tasks WHERE title = $list_title";
                    $rs = $mysqli->query($sql);
                    if ($rs->num_rows === 0) {
                        $list->writeToDB($list_title, $user_id);
                    } else {
                        echo "<p>List with the same title already exists!</p>";
                    }
                }
            }
            ?> 
            <table>
            <?php
            $mysqli->real_query("SELECT id, title, archived FROM list_of_tasks WHERE user_id = $user_id");
            $res = $mysqli->use_result();
            while ($row = $res->fetch_assoc()) {
                $list_id = $row['id'];
                $title = $row['title'];
                $archived = $row['archived'];             
                if ($archived == 'awaiting archiving') {
                     ?>  
                        <tr>
                            <td class="completedOrArchived"> <?php echo $title; ?> </td>
                            <td class="completedOrArchived" colspan="2">Awaiting archiving</td>                              
                        </tr>
                    <?php
                } elseif($archived == 'archived') {
                     ?>  
                        <tr>
                            <td class="completedOrArchived"> <?php echo $title; ?> </td>
                            <td class="completedOrArchived" colspan="2">Archived</td>                              
                        </tr>
                    <?php
                } else {
                    ?>  
                        <tr id="lists">
                            <td> <?php echo "<a href=open_list.php?list_id=" . urlencode($list_id) . "&list_title=" . urlencode($title) . ">$title</a>"; ?> </td>
                            <td>
                                <form method="post">
                                    <input type ="submit" name="delete_list" value="Delete" class="btn">
                                    <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
                                </form>
                            </td>
                            <td id="archive_td">
                                <form method="post" id="archive_form">
                                    <input type ="submit" name="archive_list" value="Archive" class="btn">
                                    <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
                                </form>
                            </td>
                        </tr>
                <?php
                }
            }
            ?>
            </table>
        </div>
    </body>
</html>
