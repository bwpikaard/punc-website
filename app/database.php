<?php
    $ini = parse_ini_file(dirname(__DIR__) . "/config.ini");
    $con = new mysqli($ini["db_host"], $ini["db_username"], $ini["db_password"], $ini["db_database"]);
    
    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . $con->connect_error;
    }
?>