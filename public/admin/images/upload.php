<?php
    session_start();
    require('../../db.php');
    include("../../auth.php");
    if ($_SESSION["administrator"] != 1) { header("Location: /"); }

    if (!isset($_FILES["file"])) return header("Location: /?error=NoImage");

    $file = $_FILES['file'];
    $file_ext = strtolower(end(explode('.', $file['name'])));

    if (!in_array($file_ext, array('png', 'jpg', 'jpeg'))) return header("Location: /?error=InvalidExtension");
    if ($file['error'] !== 0) return header("Location: /?error=FileError&err={$file['error']}");
    if ($file['size'] > 15 * 1024 * 1024) return header("Location: /?error=FileTooLarge");

    $file_name = $_POST["file-name"];
    $file_location = $_POST["location"];
    
    if (!move_uploaded_file($file['tmp_name'], "../../assets/images/$file_location/$file_name.$file_ext")) return header("Location: /?error=ServerError");
    
    header("Location: /admin");
?>
