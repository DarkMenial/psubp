<?php
require_once 'db_connect.php';
session_start();
require_once 'activity_logs.php'; 

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];
$profileId = $_POST['profile_id'];
$selectedAccounts = $_POST['accounts'] ?? [];
$selectedPermissions = $_POST['permissions'] ?? [];

// Validate and sanitize user input
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);
$profileId = mysqli_real_escape_string($conn, $profileId);

// Check if the username is already taken
$checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $checkUsernameQuery);
if (mysqli_num_rows($result) > 0) {
    echo "Error: Username is already taken.";
    exit;
}

// Hash the password for security
// $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Use password hashing for better security
$hashedPassword = password_hash($password);

// Prepare the INSERT statement for users table
$sql = "INSERT INTO users (username, password, profile_id) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, 'ssi', $username, $hashedPassword, $profileId);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        $userId = mysqli_insert_id($conn);

        // Save selected accounts for the user in account_users table
        foreach ($selectedAccounts as $account) {
            $accountQuery = "INSERT INTO account_users (user_id, account_id) VALUES (?, ?)";
            $accountStmt = mysqli_prepare($conn, $accountQuery);
            if ($accountStmt) {
                mysqli_stmt_bind_param($accountStmt, 'ii', $userId, $account);
                if (!mysqli_stmt_execute($accountStmt)) {
                    echo "Error inserting into account_users: " . mysqli_stmt_error($accountStmt);
                    exit;
                }
                mysqli_stmt_close($accountStmt);
            } else {
                echo "Error preparing account insert statement: " . mysqli_error($conn);
                exit;
            }
        }
        
        // Save selected permissions for the user in user_permissions table
        foreach ($selectedPermissions as $permission) {
            $permissionQuery = "INSERT INTO user_permissions (user_id, permission_id) VALUES (?, ?)";
            $permissionStmt = mysqli_prepare($conn, $permissionQuery);
            if ($permissionStmt) {
                mysqli_stmt_bind_param($permissionStmt, 'ii', $userId, $permission);
                if (!mysqli_stmt_execute($permissionStmt)) {
                    echo "Error inserting into user_permissions: " . mysqli_stmt_error($permissionStmt);
                    exit;
                }
                mysqli_stmt_close($permissionStmt);
            } else {
                echo "Error preparing permission insert statement: " . mysqli_error($conn);
                exit;
            }
        }

        echo "User created successfully!";
        
        // Log the user creation activity
        $userId = $_SESSION['id'];
        $accountId = $_SESSION['selected_account'];
        $logMessage = "User Created a User";
        logActivity('create_user', $logMessage, $userId, $accountId);
    
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
