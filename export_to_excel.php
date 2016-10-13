<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once './DBconnect.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $list_id = $_POST['list_id'];
    $sql_query = "SELECT * FROM task where list_id = $list_id";
    $result = $mysqli->query($sql_query);

    $f = fopen('php://temp', 'wt');
    $first = true;
    while ($row = $result->fetch_assoc()) {
        if ($first) {
            fputcsv($f, array_keys($row));
            $first = false;
        }
        fputcsv($f, $row);
    }
    $mysqli->close();

    $size = ftell($f);
    rewind($f);

    header("Content-type: application/vnd.ms-excel; name='excel'");
    header("Content-Disposition: attachment; filename=export.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    fpassthru($f);
    exit;
}

