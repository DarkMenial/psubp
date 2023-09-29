<?php
require_once 'db_connect.php';

// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Construct the SQL query to retrieve the logged-in user's account
$accountQuery = "SELECT au.account_id, a.account_name
                FROM account_users au
                JOIN accounts a ON au.account_id = a.account_id
                WHERE au.user_id = '$loggedInUserID'";
$accountResult = mysqli_query($conn, $accountQuery);

// Check if the query executed successfully and a row is returned
if ($accountResult && mysqli_num_rows($accountResult) > 0) {
    $account = mysqli_fetch_assoc($accountResult);
    $loggedInAccountID = $account['account_id'];
    $loggedInAccountName = $account['account_name'];

    // Get the selected account filter value
    $filterAccount = isset($_GET['filter-account']) ? $_GET['filter-account'] : 'all';

    // Construct the SQL query based on the filter values
    $query = "SELECT p.id, p.title, t.topic_name, a.account_name, u.full_name, p.publish, p.date_posted
    
              FROM posts p
              JOIN users u ON p.user_id = u.id
              JOIN account_users au ON u.id = au.user_id
              JOIN accounts a ON au.account_id = a.account_id
              JOIN topics t ON p.topic_id = t.topic_id";

    // Add the account filter condition if a specific account is selected
    if ($loggedInAccountName !== 'BSCRIM') {
        $query .= " WHERE au.account_id = '$loggedInAccountID'";
    }

    // Execute the SELECT query
    $result = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($result) {
        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            // Display the posts
            while ($post = mysqli_fetch_assoc($result)) {
                echo '<tr>';

                echo '<td>';
                echo '<span>' . strtoupper($post['account_name']) . '</span><br>';
                echo '<span style="opacity: 0.9; font-size: 13px;">' . $post['full_name'] . '</span>';
                echo '</td>';

                echo '<td>' . $post['title'] . '</td>';
                echo '<td>' . $post['topic_name'] . '</td>';
                echo '<td>' . $post['date_posted'] . '</td>';
                echo '<td>';
                echo '<a href="../admin/edit_post.php?id=' . $post['id'] . '">Edit</a> | ';
                echo '<a href="?delete_id=' . $post['id'] . '" onclick="return confirm(\'Are you sure you want to delete this post?\')">Delete</a> | ';

                // Publish/Unpublish link based on the 'publish' value
                if ($post['publish'] == 1) {
                    echo '<a href="./php/publish_post.php?id=' . $post['id'] . '&publish=0">Unpublish</a> | ';
                } else {
                    echo '<a href="./php/publish_post.php?id=' . $post['id'] . '&publish=1">Publish</a> | ';
                }

                // Rest of your action links
                echo '</td>';
                echo '</tr>';
            }
        } else {
            // No posts found
            echo '<tr><td colspan="5">No posts found</td></tr>';
        }

        // Free the result set
        mysqli_free_result($result);
    } else {
        // Display the MySQL error
        echo 'Query error: ' . mysqli_error($conn);
    }

    // Free the account result set
    mysqli_free_result($accountResult);
} else {
    // No account found for the logged-in user
    echo 'No account found for the logged-in user.';
}

// Delete post
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Delete the post from the database
    $deleteQuery = "DELETE FROM posts WHERE id = '$deleteId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('Post deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting post: " . mysqli_error($conn) . "');</script>";
    }
}
?>