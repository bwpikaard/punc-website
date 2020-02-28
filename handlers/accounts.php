<?php
    require_once("database.php");

    function select_account($username) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM accounts WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();

        return $stmt->get_result();
    }

    function select_account_by_id($id) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM accounts WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }
    
    function select_accounts() {
        global $con;

        $stmt = "SELECT * FROM accounts";
        $result = $con->query($stmt);

        return $result;
    }
    
    function select_accounts_by_type($type) {
        global $con;

        if ($type) {
            $stmt = "SELECT * FROM accounts WHERE `type`='$type'";
        } else {
            $stmt = "SELECT * FROM accounts";
        }

        $result = $con->query($stmt);

        return $result;
    }

    function insert_account($username, $email, $displayname, $password) {
        global $con;
        
        $created = date("Y-m-d H:i:s");

        $stmt = $con->prepare("INSERT INTO accounts (username, email, displayname, password, administrator, created) VALUES (?, ?, ?, ?, '0', '$created')");
        $stmt->bind_param("ssss", $username, $email, $displayname, $password);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function update_account($id, $firstname, $lastname, $email, $website, $institution, $expertise, $instrumentation, $biography) {
        global $con;

        if ($expertise == "") $expertise = null;
        if ($instrumentation == "") $instrumentation = null;
        if ($biography == "") $biography = null;

        echo var_dump($id, $firstname, $lastname, $email, $website, $institution, $expertise, $biography);

        $stmt = $con->prepare("UPDATE accounts SET username=?, administrator=?, firstname=?, lastname=?, email=?, website=?, institution=?, expertise=?, instrumentation=?, biography=? WHERE id='$id'");
        $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $website, $institution, $expertise, $instrumentation, $biography);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function update_account_admin($id, $type, $active, $username, $administrator, $firstname, $lastname, $email, $website, $institution, $expertise, $instrumentation, $biography) {
        global $con;

        if ($expertise == "") $expertise = null;
        if ($instrumentation == "") $instrumentation = null;
        if ($biography == "") $biography = null;

        $stmt = $con->prepare("UPDATE accounts SET type=?, active=?, username=?, administrator=?, firstname=?, lastname=?, email=?, website=?, institution=?, expertise=?, instrumentation=?, biography=? WHERE id='$id'");
        $stmt->bind_param("iisissssssss", intval($type), intval($active), $username, intval($administrator), $firstname, $lastname, $email, $website, $institution, $expertise, $instrumentation, $biography);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function delete_account($id) {
        global $con;

        $stmt = "DELETE FROM accounts WHERE id='$id'";
        $result = $con->query($stmt);
        
        return $result->affected_rows >= 1;
    }
?>