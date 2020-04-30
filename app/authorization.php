<?php
    function has_session() {
        return isset($_SESSION['user']);
    }

    function check_permission($module, $id) {
        if (!$_SESSION['user']['permissions'] || !$_SESSION['user']['permissions'][$module]) return false;
        return in_array($id, $_SESSION['user']['permissions'][$module]);
    }

    function admin_panel() {
        return check_permission("USER", 1);
    }