<?php
include_once './DBconnect.php';

class User {

    private $email = null;
    private $password = null;
    private $role = null;

    function __construct($email, $password, $role) {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    function writeToDB($email, $password, $role) {
        global $mysqli;
        $sql = "INSERT INTO user (email, password, role) VALUES ($email, $password, $role)";

        try {
            if ($mysqli->query($sql) === false) {
                throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
            } else {
                $_SESSION['user'] = $email;
                header('Location: registered.php');
                exit;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
