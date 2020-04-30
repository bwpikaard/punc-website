<?php
    require_once("database.php");

    function select_user_by_identifier($identifier) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM `users` LEFT JOIN `roles` USING (`role_id`) WHERE username=? OR email=?");
        $stmt->bind_param("ss", $identifier, $identifier);
        $stmt->execute();

        return $stmt->get_result();
    }

    function select_user_permissions() {
        global $con;

        $stmt = $con->prepare("SELECT * FROM `roles_permissions` WHERE `role_id`=?");
        $stmt->bind_param("i", $_SESSION["user"]["role_id"]);
        $stmt->execute();

        return $stmt->get_result();
    }

    function select_user_by_id($id) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM `users` WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }

    function select_users() {
        global $con;

        $stmt = "SELECT * FROM `users`";
        $result = $con->query($stmt);

        return $result;
    }

    function select_users_by_type($type) {
        global $con;

        if ($type) $stmt = "SELECT * FROM `users` WHERE `type`='$type'";
        else $stmt = "SELECT * FROM `users`";

        $result = $con->query($stmt);

        return $result;
    }

    function insert_user($username, $password, $firstname, $lastname, $email) {
        global $con;
            
        $created = date("Y-m-d H:i:s");

        $stmt = $con->prepare("INSERT INTO `users` (`type`, `status`, `role_id`, `username`, `password`, `firstname`, `lastname`, `email`, `created`)
        VALUES (1, 0, 1, ?, ?, ?, ?, ?, '$created')");
        $stmt->bind_param("sssss", $username, $password, $firstname, $lastname, $email);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function update_user($id, $firstname, $lastname, $email, $website, $institution, $expertise, $instrumentation, $biography) {
        global $con;

        if ($expertise == "") $expertise = null;
        if ($instrumentation == "") $instrumentation = null;
        if ($biography == "") $biography = null;

        $stmt = $con->prepare("UPDATE `users` SET firstname=?, lastname=?, email=?, website=?, institution=?, expertise=?, instrumentation=?, biography=? WHERE id='$id'");
        $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $website, $institution, $expertise, $instrumentation, $biography);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function update_user_admin($id, $type, $status, $role_id, $username, $firstname, $lastname, $email, $website, $institution, $expertise, $instrumentation, $biography) {
        global $con;

        if ($expertise == "") $expertise = null;
        if ($instrumentation == "") $instrumentation = null;
        if ($biography == "") $biography = null;

        $stmt = $con->prepare("UPDATE `users` SET type=?, status=?, role_id=?, username=?, firstname=?, lastname=?, email=?, website=?, institution=?, expertise=?, instrumentation=?, biography=? WHERE id='$id'");
        $stmt->bind_param("iiisssssssss", intval($type), intval($status), intval($role_id), $username, $firstname, $lastname, $email, $website, $institution, $expertise, $instrumentation, $biography);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function delete_user($id) {
        global $con;

        $stmt = "DELETE FROM `users` WHERE id='$id'";
        $result = $con->query($stmt);
        
        return $result->affected_rows >= 1;
    }