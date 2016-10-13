<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once './DBconnect.php';
include_once 'Task.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
    </head>
    <body>
        <script>
            function validateInput(input_id) {
                var input_value = document.getElementById(input_id).value;
                if (input_value.length === 0) {
                    alert('Please, select a date!');
                    return false;
                } else {
                    return true;
                }
            }
        </script>
        <div class="container">
            <button onclick="location.href = 'logout.php';" class="btn">Logout</button>
            <button onclick="location.href = 'user_page.php';" class="btn">Back to lists page</button>
            
            <?php
            $list_id = $_GET['list_id'];
            $list_title = $_GET['list_title'];
            ?>
            <h3>List "<?php echo $list_title; ?>"</h3>
            <p>Add new task:
            <form method="POST">
                <textarea name="text" rows="4" cols="50"></textarea>
                <br>
                <input type="submit" name="save_task" class="btn" value="Save">       
            </form>
            </p>
            <br>
            <p>
            <h4>Select tasks by:</h4>
                <form method="POST" action="selected_tasks.php">
                        Status:
                        <select name="filter_tasks">
                            <option value="open">Open</option>
                            <option value="completed">Completed</option>                        
                        </select>
                        <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
                        <input type="submit" value="Show" name="show_tasks_by_status" class="btn">
                    </form>
                 <form method="POST" onsubmit="return validateInput('date_added');"action="selected_tasks.php" >
                        Date added:
                            <input type="date" name="date_added" id="date_added">
                            <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
                        <input type="submit" value="Show" name="show_tasks_by_date" class="btn">
                    </form>
                </p>
                <br>
            <p>
            <form method="POST" name="export" action="export_to_excel.php">
                    <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
                    <input type="submit" value="Export all tasks to excel" name="submit" class="btn">
                </form>
            </p>
        <?php
        if (isset($_POST['delete_task'])) {
            $task_id = $_POST['task_id'];

            $sql = "DELETE FROM task WHERE id = $task_id";

            if ($mysqli->query($sql) === false) {
                trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
            } else {
                
            }
        }

        if (isset($_POST['save_task'])) {
            try {
                if (empty($_POST['text']) || strlen($_POST['text']) < 3 || strlen($_POST['text']) > 200) {
                    throw new Exception("<p>Please, enter text between 3 and 200 characters!</p>");
                } else {
                    $text_input = htmlentities($_POST['text']);
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            if (!empty($text_input)) {
                $text = "'$text_input'";

                $task = new Task($text, $list_id);

                $task->writeToDB($text, $list_id);
            } else {
                
            }
        }
        ?>
        <table>
            <?php
            $mysqli->real_query("SELECT id, text, status, date_added FROM task WHERE list_id = $list_id");
            $res = $mysqli->use_result();

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
                } elseif($status == 'completed') {
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
    </div>
</body>
</html>
