<?php
session_start();
require_once 'db_connect.php';
require_once 'activity_logs.php'; // Include the activity_logs.php file
require_once 'get_session.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        
        // Check if 'name' column exists in the result set before setting $_SESSION['name']
        $_SESSION['name'] = $row['name'] ?? ""; // Using null coalescing operator for cleaner code
        $_SESSION['id'] = $row['id'];

        // Add the user's session to the database
        $sessionId = session_id();
        addSession($_SESSION['id'], $sessionId);

        // Request OTP
        header("Location: ../../admin/php/send_otp.php");
        exit();
    } else {
        // If login fails, set an error message
        $_SESSION['error'] = "Incorrect Username or Password";
        header("Location: ../../admin/login.php");
        exit();
    }
} else {
    // If username or password is not set in POST request
    $_SESSION['error'] = "Please enter both username and password";
    header("Location: ../../admin/login.php");
    exit();
}
?>
