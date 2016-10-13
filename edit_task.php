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

            <?php
            $task_id = $_GET['task_id'];
            $task_text = $_GET['task_text'];
            ?>
            <h3>Edit task</h3>
            <form method="POST">
                <textarea name="text" rows="4" cols="50"><?php echo $task_text; ?></textarea>
                <br>
                <input type="checkbox" name="status" value="completed">Set as completed
                <br>
                <br>
                <input type="submit" name="save_changes" class="btn" value="Save changes">       
            </form>

            <?php
            if (isset($_POST['save_changes'])) {
                try {
                    if (empty($_POST['text']) || strlen($_POST['text']) < 3 || strlen($_POST['text']) > 200) {
                        throw new Exception("<p>Please, enter text between 3 and 200 characters!</p>");
                    } else {
                        $edited_text_input = htmlentities($_POST['text']);
                    }
                    if (!empty($_POST['status'])) {
                        if ($_POST['status'] === 'completed') {
                            $status = "'completed'";
                        } else {
                            $status = "'open'";
                        }
                    } else {
                        $status = "'open'";
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                if (!empty($edited_text_input) && !empty($status)) {
                    $edited_text = "'$edited_text_input'";

                    $sql_post = "UPDATE task SET text = $edited_text, status = $status WHERE id = $task_id";

                    if ($mysqli->query($sql_post) === false) {
                        trigger_error('Wrong SQL: ' . $sql_post . ' Error: ' . $mysqli->error, E_USER_ERROR);
                    } else {
                        echo "<p>Changes saved</p>";
                    }
                } else {
                    
                }
            }
            ?>
        </div>
    </body>
</html>
