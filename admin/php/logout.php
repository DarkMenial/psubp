<?php
session_start();
require_once 'db_connect.php';
require_once 'activity_logs.php';
require_once 'get_device.php'; 
require_once 'get_session.php'; 

// Ensure user ID and account ID are set in the session
if (isset($_SESSION['id'], $_SESSION['selected_account'])) {
    $userId = $_SESSION['id'];
    $accountId = $_SESSION['selected_account'];

    // Log the logout activity along with device information
    $logMessage = "User logged out";
    $logMessage .= " Device: " . getDevice(); 
    logActivity('logout', $logMessage, $userId, $accountId);

    // Mark the session as inactive
    removeSession(session_id());  

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
} else {
    // Handle the case where user ID or account ID is not set in the session
    // You may choose to log this as an error or take other appropriate action
}

// Redirect the user to the login page or any other desired location
header("Location: ../login.php");
exit();
?>
