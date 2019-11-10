<?php
    require_once("database.php");

    function select_member($id) {
        global $con;

        $stmt = "SELECT * FROM members WHERE id='$id'";
        $result = $con->query($stmt);

        return $result;
    }

    function select_members() {
        global $con;

        $stmt = "SELECT * FROM members";
        $result = $con->query($stmt);

        return $result;
    }

    function insert_member($username, $email, $displayname, $password) {
        global $con;
        
        $created = date("Y-m-d H:i:s");

        $stmt = $con->prepare("INSERT INTO users (username, email, displayname, password, administrator, created) VALUES (?, ?, ?, ?, '0', '$created')");
        $stmt->bind_param("ssss", $username, $email, $displayname, $password);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function update_member() {
        global $con;


    }

    function delete_member($id) {
        global $con;

        $stmt = "DELETE FROM members WHERE id='$id'";
        $result = $con->query($stmt);
        
        return $result;
    }
?>