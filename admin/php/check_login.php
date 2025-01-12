<?php
require_once './php/db_connect.php';
session_start();

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header("Location: login.php");
    exit;
}


// Continue with the rest of the code for dashboard.php
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    if (!isset($_SESSION['sidebarCollapsed'])) {
        $_SESSION['sidebarCollapsed'] = false;
    }

    if (isset($_GET['toggle'])) {
        $_SESSION['sidebarCollapsed'] = !$_SESSION['sidebarCollapsed'];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
