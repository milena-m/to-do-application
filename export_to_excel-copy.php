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

            if (isset($_POST['submit'])) {
                $list_id = $_POST['list_id'];

                $filename = "uploads/" . strtotime("now") . '.csv';

                $res = $mysqli->query("SELECT * FROM task where list_id = $list_id") or die(mysql_error());

                $row_cnt = $res->num_rows;
                    if ($row_cnt !== 0) {
                    $row = $mysqli_fetch_assoc($sql);
                    $fp = fopen($filename, "w");
                    $seperator = "";
                    $comma = "";

                    foreach ($row as $name => $value) {
                        $seperator .= $comma . '' . str_replace('', '""', $name);
                        $comma = ",";
                    }

                    $seperator .= "\n";
                    fputs($fp, $seperator);

                    mysql_data_seek($sql, 0);
                    while ($row = mysql_fetch_assoc($sql)) {
                        $seperator = "";
                        $comma = "";

                        foreach ($row as $name => $value) {
                            $seperator .= $comma . '' . str_replace('', '""', $value);
                            $comma = ",";
                        }

                        $seperator .= "\n";
                        fputs($fp, $seperator);
                    }

                    fclose($fp);
                    echo "Your file is ready. You can download it from <a href='$filename'>here!</a>";
                } else {
                    echo "There is no record in your Database";
                }
            }
            ?>
        </div>
    </body>
</html>
