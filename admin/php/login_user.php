<?php
session_start();
require_once 'db_connect.php';
require_once 'activity_logs.php'; // Include the activity_logs.php file

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check username and password against database
    // Replace this with your actual login validation code
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        // Log successful login activity
        logActivity('login', 'User logged in successfully', $_SESSION['id']);
        // Set session for partial login
        $_SESSION['isLoggedIn'] = true;
        // Redirect to select_account.php
        header("Location: ../login.php");
        exit();
    } else {
        // Log failed login activity
        logActivity('login_failed', 'Failed login attempt for username: ' . $username);
        
        $_SESSION['error'] = "Incorrect username or password";
        header("Location: ../login.php");
        exit();
    }
} else {
    // Log failed login activity if username or password is not provided
    logActivity('login_failed', 'Failed login attempt: Username or password missing');
    
    $_SESSION['error'] = "Username and password are required";
    header("Location: ../login.php");
    exit();
}
?>
