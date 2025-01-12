<?php
require_once 'db_connect.php';

// Function to log activities
function logActivity($action, $description, $userId = null, $selectedAccountId) {
global $conn;

    // Get the current timestamp
    $timestamp = date('Y-m-d H:i:s');

    // Escape the description to prevent SQL injection
    $description = mysqli_real_escape_string($conn, $description);

    // If the user ID is provided, include it in the log
    if ($userId) {
        // Escape the user ID to prevent SQL injection
        $userId = mysqli_real_escape_string($conn, $userId);

        // Insert the activity log into the database
        $query = "INSERT INTO activity_logs (action, description, user_id, account_id, timestamp) VALUES ('$action', '$description', '$userId', '$selectedAccountId', '$timestamp')";
    } else {
        // Insert the activity log into the database without the user ID
        $query = "INSERT INTO activity_logs (action, description, timestamp) VALUES ('$action', '$description', '$timestamp')";
    }

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($result) {
        // Log successful activity
        echo "Activity logged successfully: $action - $description <br>";
    } else {
        // Log error if the query failed
        echo "Error logging activity: " . mysqli_error($conn) . "<br>";
    }
}

// Example usage:
// logActivity('deleted', 'Deleted a post', 123); // Assuming 123 is the user ID who deleted the post
// logActivity('updated', 'Updated a user profile'); // No specific user ID provided
?>
