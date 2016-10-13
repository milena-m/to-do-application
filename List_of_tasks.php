<?php

include_once './DBconnect.php';

class List_of_tasks {

    private $title = null;
   // private $date_added = null;
    private $user_id = null;

    function __construct($title, $user_id) {
        $this->title = $title;
        $this->user_id = $user_id;
    }

    function writeToDB($title, $user_id) {
        global $mysqli;
        $sql = "INSERT INTO list_of_tasks (title, user_id) VALUES ($title, $user_id)";

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
