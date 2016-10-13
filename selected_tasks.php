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
            <button onclick="location.href = 'user_page.php';" class="btn">Back to lists page</button>
            <br><br>
            <?php
            $user_id = $_SESSION['user_id'];

            if (isset($_POST['show_tasks_by_status'])) {
                $list_id = $_POST['list_id'];

                if ($_POST['filter_tasks'] == 'open') {
                    $res = $mysqli->query("SELECT task.id, task.text, task.status, task.date_added FROM task INNER JOIN list_of_tasks ON task.list_id = list_of_tasks.id WHERE list_id = $list_id AND task.status = 'open' ");
                    $row_cnt = $res->num_rows;
                    if ($row_cnt !== 0) {
                        ?>
                        <table>
                            <?php
                            while ($row = $res->fetch_assoc()) {
                                $task_id = $row['id'];
                                $text = $row['text'];
                                $status = $row['status'];
                                $date_added = $row['date_added'];
                                ?>  
                                <tr>
                                    <td><?php echo "<a href=edit_task.php?task_id=" . urlencode($task_id) . "&task_text=" . urlencode($text) . ">$text</a>"; ?> </td>
                                    <td>Status: <?php echo $status; ?></td>
                                    <td>Added: <?php echo date('d-m-Y', strtotime($date_added)); ?></td>
                                    <td>
                                        <form method="post">
                                            <input type ="submit" name="delete_task" value="Delete" class="btn">
                                            <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
                                        </form>
                                    </td>
                                </tr>                    

                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    } else {
                        echo "No tasks to show.";
                    }
                } elseif ($_POST['filter_tasks'] == 'completed') {
                    $list_id = $_POST['list_id'];
                    $res = $mysqli->query("SELECT task.id, task.text, task.status, task.date_added FROM task INNER JOIN list_of_tasks ON task.list_id = list_of_tasks.id WHERE list_id = $list_id AND task.status = 'completed' ");
                    $row_cnt = $res->num_rows;
                    if ($row_cnt !== 0) {
                        ?>
                        <table>
                            <?php
                            while ($row = $res->fetch_assoc()) {
                                $task_id = $row['id'];
                                $text = $row['text'];
                                $status = $row['status'];
                                $date_added = $row['date_added'];
                                ?>  
                                <tr>
                                    <td class='completedOrArchived'><?php echo $text; ?> </td>
                                    <td class='completedOrArchived'>Status: <?php echo $status; ?></td>
                                    <td class='completedOrArchived'>Added: <?php echo date('d-m-Y', strtotime($date_added)); ?></td>
                                    <td>
                                        <form method="post">
                                            <input type ="submit" name="delete_task" value="Delete" class="btn">
                                            <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
                                        </form>
                                    </td>
                                </tr>           
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    } else {
                        echo "No tasks to show.";
                    }
                }
            }

            if (isset($_POST['show_tasks_by_date'])) {
                if (empty($_POST['date_added'])) {
                    echo "Please, select a date!";
                } else {
                    $date_added_input = $_POST['date_added'];
                    $date_added = "'" . $date_added_input . "%'";
                    $res = $mysqli->query("SELECT task.id, task.text, task.status, task.date_added FROM task INNER JOIN list_of_tasks ON task.list_id = list_of_tasks.id WHERE user_id = $user_id AND task.date_added LIKE $date_added");
                    $row_cnt = $res->num_rows;
                    if ($row_cnt !== 0) {
                        ?>
                        <table>
                            <?php
                            while ($row = $res->fetch_assoc()) {
                                $task_id = $row['id'];
                                $text = $row['text'];
                                $status = $row['status'];
                                $date_added = $row['date_added'];

                                if ($status == 'open') {
                                    ?>  
                                    <tr>
                                        <td><?php echo "<a href=edit_task.php?task_id=" . urlencode($task_id) . "&task_text=" . urlencode($text) . ">$text</a>"; ?> </td>
                                        <td>Status: <?php echo $status; ?></td>
                                        <td>Added: <?php echo date('d-m-Y', strtotime($date_added)); ?></td>
                                        <td>
                                            <form method="post">
                                                <input type ="submit" name="delete_task" value="Delete" class="btn">
                                                <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                } elseif ($status == 'completed') {
                                    ?>  
                                    <tr>
                                        <td class='completedOrArchived'><?php echo $text; ?> </td>
                                        <td class='completedOrArchived'>Status: <?php echo $status; ?></td>
                                        <td class='completedOrArchived'>Added: <?php echo date('d-m-Y', strtotime($date_added)); ?></td>
                                        <td>
                                            <form method="post">
                                                <input type ="submit" name="delete_task" value="Delete" class="btn">
                                                <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                        <?php
                    } else {
                        echo "No results found.";
                    }
                }
            }
            ?>
        </div>
    </body>
</html>
