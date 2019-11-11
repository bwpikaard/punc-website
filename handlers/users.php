<?php
    require_once("database.php");

    function select_user($username) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();

        return $stmt->get_result();
    }
    
    function select_users() {
        global $con;

        $stmt = "SELECT * FROM users";
        $result = $con->query($stmt);

        return $result;
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

    function update_user($id, $username, $email, $displayname, $administrator, $password) {
        global $con;

        if ($password) {
            $stmt = $con->prepare("UPDATE users SET username=?, email=?, displayname=?, administrator=?, password=? WHERE id='$id'");
            $stmt->bind_param("ssss", $username, $email, $displayname, $administrator, $password);
        } else {
            $stmt = $con->prepare("UPDATE users SET username=?, email=?, displayname=?, administrator=? WHERE id='$id'");
            $stmt->bind_param("sss", $username, $email, $displayname, $administrator);
        }
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function delete_user($id) {
        global $con;

        $stmt = "DELETE FROM users WHERE id='$id'";
        $result = $con->query($stmt);
        
        return $result->affected_rows >= 1;
    }
?>