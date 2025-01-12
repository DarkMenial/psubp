<?php
require_once 'db_connect.php';

// Check if the post ID is provided
if(isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    // Construct the SQL query to fetch audit trail data with additional information
    $query = "SELECT audit_trail.*, users.username, profiles.name, posts.title 
              FROM audit_trail 
              INNER JOIN users ON audit_trail.user_id = users.id 
              INNER JOIN profiles ON users.profile_id = profiles.id
              INNER JOIN posts ON audit_trail.post_id = posts.id 
              WHERE audit_trail.post_id = '$postId'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($result) {
        // Check if any audit trail records are returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch and display the audit trail records
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<p><strong>Action:</strong> ' . $row['action'] . '</p>';
                echo '<p><strong>User Name:</strong> ' . $row['username'] . '</p>';
                echo '<p><strong>Profile Name:</strong> ' . $row['name'] . '</p>';
                echo '<p><strong>Post Title:</strong> ' . $row['title'] . '</p>';
                echo '<p><strong>Timestamp:</strong> ' . $row['timestamp'] . '</p>';
                echo '<hr>';
            }
        } else {
            // No audit trail records found for the specified post
            echo '<p>No audit trail records found for this post.</p>';
        }
    } else {
        // Display an error message if the query fails
        echo 'Query error: ' . mysqli_error($conn);
    }

    // Free the result set
    mysqli_free_result($result);

    // Close the database connection
    mysqli_close($conn);
} else {
    // Display an error message if the post ID is not provided
    echo 'Error: Post ID is not provided.';
}
?>
