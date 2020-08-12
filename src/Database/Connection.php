<?php

namespace App\Database;

use \mysqli;

final class Connection {
    public $connection;

    public function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if ($this->connection->connect_error) die("Failed to connect to MySQL database!");
    }

    public function select($stmt) {
        $result = $this->connection->query($stmt);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function select_where($stmt, $types, ...$data) {
        $stmt = $this->connection->prepare($stmt);
        $stmt->bind_param($types, ...$data);
        $stmt->execute();

        return $stmt->get_result();
    }
    
    public function alter($stmt, $types, ...$data) {
        $stmt = $this->connection->prepare($stmt);
        $stmt->bind_param($types, ...$data);
        $stmt->execute();

        return $stmt;
    }

    public function done() {
        $this->connection->close();
    }
}