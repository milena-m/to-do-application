<?php
include_once './DBconnect.php';

class Task {

    private $text = null;
    private $list_id = null;

    function __construct($text, $list_id) {
        $this->text = $text;
        $this->list_id = $list_id;
    }

    function writeToDB($text, $list_id) {
        global $mysqli;
        $sql = "INSERT INTO task (text, list_id) VALUES ($text, $list_id)";

        try {
            if ($mysqli->query($sql) === false) {
                throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
            } else {
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
