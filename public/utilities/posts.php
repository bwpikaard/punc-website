<?php
    session_start();
    require_once("../../app/posts.php");
    
    if ($_SESSION["administrator"] != 1) {
        header("Location: /");
        exit;
    }

    if (isset($_GET["delete"])) {

    } else if (isset($_GET["publish"])) {

    } else if (isset($_POST["edit"])) {

    } else if (isset($_POST["create"])) {

    }
?>