<?php
    require_once("database.php");

    function select_configuration($key) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM configuration WHERE `key`=? LIMIT 1");
        $stmt->bind_param("s", $key);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()["value"];
    }
?>