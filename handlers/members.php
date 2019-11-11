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

    function update_member($id, $name, $image, $website, $institution, $institution_image, $expertise, $instrumentation, $biography) {
        global $con;
        
        $stmt = $con->prepare("UPDATE members SET name=?, image=?, website=?, institution=?, institution_image=?, expertise=?, instrumentation=?, biography=? WHERE id='$id'");
        $stmt->bind_param("ssssssss", $name, $image, $website, $institution, $institution_image, $expertise, $institution, $biography);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function delete_member($id) {
        global $con;

        $stmt = "DELETE FROM members WHERE id='$id'";
        $result = $con->query($stmt);
        
        return $result;
    }
?>