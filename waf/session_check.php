<?php

session_start();

function isSessionValid() {
    if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
        return false;
    }

    if (time() - $_SESSION['verified_time'] > 1800) {
        session_unset();
        session_destroy();
        return false;
    }

    return true;
}

if (!isSessionValid()) {
    header("Location: /robot");
    exit;
}
?>
