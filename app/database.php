<?php
    $config = parse_ini_file(dirname(__DIR__) . "/config.ini");

    $con = new mysqli(
        $config["db_host"],
        $config["db_username"],
        $config["db_password"],
        $config["db_database"]
    );
        
    if ($con->connect_error) {
        echo "Failed to connect to MySQL: " . $con->connect_error;
    }