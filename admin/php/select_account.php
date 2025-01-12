<?php
session_start();
require_once 'db_connect.php';
require_once 'activity_logs.php';

if (isset($_POST['selected_account'], $_SESSION['id'])) {
    $selectedAccountId = (int)$_POST['selected_account']; // Cast for added security
    $userId = (int)$_SESSION['id'];

    // Fetch username
    $usernameQuery = "SELECT username FROM users WHERE id = ?";
    $stmt = $conn->prepare($usernameQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();

    // Fetch account name
    $accountNameQuery = "SELECT account_name FROM accounts WHERE account_id = ?";
    $stmt = $conn->prepare($accountNameQuery);
    $stmt->bind_param("i", $selectedAccountId);
    $stmt->execute();
    $stmt->bind_result($accountName);
    $stmt->fetch();
    $stmt->close();

    $_SESSION['selected_account'] = $selectedAccountId;
    $_SESSION['isLoggedIn'] = true;

    // Log activity
    $logMessage = "$username logged in successfully to $accountName";
    logActivity('login', $logMessage, $userId, $selectedAccountId);

    header("Location: ../../admin/dashboard.php");
    exit();
} else {
    header("Location: ../../admin/login.php");
    exit();
}
?>
