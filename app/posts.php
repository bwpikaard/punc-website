<?php
    require_once("database.php");

    function select_author($id) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    function select_posts() {
        global $con;

        $stmt = "SELECT * FROM posts";
        $result = $con->query($stmt);

        return $result;
    }
?>