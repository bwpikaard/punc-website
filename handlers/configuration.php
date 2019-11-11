<?php
    require_once("database.php");

    function select_configuration($key) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM configuration WHERE `key`=? LIMIT 1");
        $stmt->bind_param("s", $key);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()["value"];
    }

    function select_configurations() {
        global $con;

        $stmt = "SELECT * FROM configuration";
        $result = $con->query($stmt);

        return $result;
    }

    function update_configuration($key, $updatedkey, $value) {
        global $con;

        $stmt = $con->prepare("UPDATE configuration SET key=?, value=? WHERE key='$key'");
        $stmt->bind_param("ss", $updatedkey, $value);
        $stmt->execute();
        
        $rows = $stmt->affected_rows;

        $stmt->close();

        return $rows >= 1;
    }

    function delete_configuration($key) {
        global $con;

        $stmt = "DELETE FROM configuration WHERE key='$key'";
        $result = $con->query($stmt);
        
        return $result;
    }
?>