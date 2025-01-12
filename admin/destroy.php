<?php
session_start();
require_once 'php/db_connect.php';

// Debug: Inspect session data before attempting to destroy the session
echo "Session data before destruction attempt: ";
var_dump($_SESSION);

// Unset all session variables
$_SESSION = array();

// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Debug: Inspect session data after attempting to destroy the session
echo "Session data after destruction attempt: ";
var_dump($_SESSION);

// Redirect the user to the login page or any other desired location
header("Location: login.php");
exit;
?>
