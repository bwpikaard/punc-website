<?php
    require_once("database.php");

    function select_user($username) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();

        return $stmt->get_result();
    }

    function insert_user($username, $email, $displayname, $password) {
        global $con;
        
        $created = date("Y-m-d H:i:s");

        $stmt = $con->prepare("INSERT INTO users (username, email, displayname, password, administrator, created) VALUES (?, ?, ?, ?, '0', '$created')");
        $stmt->bind_param("ssss", $username, $email, $displayname, $password);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function update_user() {
        global $con;


    }
?>