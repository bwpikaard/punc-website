<?php
    session_start();
    require_once("../../handlers/authorization.php");
    require_once("../../handlers/configuration.php");

    if (isset($_POST["register"])) {
        not_administrator();

        $key = trim($_POST["key"]);
        $value = trim($_POST["value"]);
        
        $result = insert_configuration($key, $value);

        header("Location: /admin#configuration");
    } else if (isset($_POST["update"])) {
        not_administrator();
        
        $id = trim($_POST["id"]);
        $key = trim($_POST["key"]);
        $value = trim($_POST["value"]);

        $result = update_configuration($id, $key, $value);

        header("Location: /admin#configuration");
    } else if (isset($_GET["delete"])) {
        not_administrator();
        
        $key = $_GET["key"];

        $result = delete_configuration($key);

        header("Location: /admin#configuration");
    }
?>