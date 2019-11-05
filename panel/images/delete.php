<?php
    session_start();
    require('../../db.php');
    include("../../auth.php");
    if ($_SESSION["administrator"] != 1) { header("Location: /"); }

    $file_name = $_GET["file_name"];
    $file_location = $_GET["file_location"];
    
    if (file_exists("../../assets/images/$file_location/$file_name"))
        if (!unlink("../../assets/images/$file_location/$file_name")) return header("Location: /?error=ServerError");
    else {
        header("Location: /?exists=false");
    }

    header("Location: /panel");
?>