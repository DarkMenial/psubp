<?php
require_once 'db_connect.php';
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$selectedAccounts = $_POST['accounts'] ?? [];
$selectedPermissions = $_POST['permissions'] ?? [];

// Validate and sanitize user input
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);
$email = mysqli_real_escape_string($conn, $email);

// Check if the username is already taken
$checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $checkUsernameQuery);
if (mysqli_num_rows($result) > 0) {
    echo "Error: Username is already taken.";
    exit;
}

// Hash the password for security
// $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$hashedPassword = $password;


// Prepare the INSERT statement for users table
$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, 'sss', $username, $hashedPassword, $email);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        $userId = mysqli_insert_id($conn);

        // Save selected accounts for the user in account_users table
        foreach ($selectedAccounts as $accountId) {
            $accountUserQuery = "INSERT INTO account_users (account_id, user_id) VALUES (?, ?)";
            $accountUserStmt = mysqli_prepare($conn, $accountUserQuery);
            mysqli_stmt_bind_param($accountUserStmt, 'ii', $accountId, $userId);
            mysqli_stmt_execute($accountUserStmt);
            mysqli_stmt_close($accountUserStmt);
        }

        // Save selected permissions for the user in user_permissions table
        foreach ($selectedPermissions as $permission) {
            $permissionQuery = "INSERT INTO user_permissions (user_id, permission_id) VALUES (?, ?)";
            $permissionStmt = mysqli_prepare($conn, $permissionQuery);
            mysqli_stmt_bind_param($permissionStmt, 'ii', $userId, $permission);
            mysqli_stmt_execute($permissionStmt);
            mysqli_stmt_close($permissionStmt);
        }

        echo "User created successfully!";
    } else {
        echo "Error creating user: " . mysqli_stmt_error($stmt);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($conn);
    exit;
}

// Close the database connection
mysqli_close($conn);
?>
