<?php
    function is_logged() {
        return isset($_SESSION["id"]);
    }

    function is_administrator() {
        return $_SESSION["administrator"] == 1;
    }

    function not_logged() {
        if(!is_logged()) {
            header("Location: /login");
            exit();
        }
    }

    function not_administrator() {
        if (!is_administrator()) {
            header("Location: /login");
            exit;
        }
    }
?>