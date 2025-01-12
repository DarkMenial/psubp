<?php
require_once 'db_connect.php';


// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Retrieve the selected account ID from the session or URL parameter
$selectedAccountID = isset($_SESSION['selected_account']) ? $_SESSION['selected_account'] : null;

// Construct the SQL query to retrieve the logged-in user's account
$accountQuery = "SELECT au.account_id, a.account_name
                FROM account_users au
                JOIN accounts a ON au.account_id = a.account_id";
$accountResult = mysqli_query($conn, $accountQuery);

// Check if the query executed successfully and a row is returned
if ($accountResult && mysqli_num_rows($accountResult) > 0) {
    $account = mysqli_fetch_assoc($accountResult);
}


// Add a condition to filter by selected account ID, if available
if ($selectedAccountID) {
    $accountQuery .= " AND au.account_id = '$selectedAccountID'";
}


// Get the filter values
$filterPosition = $_GET['filter-position'] ?? 'all';

// Construct the SQL query based on the filter values
$activityQuery = "SELECT al.*, a.account_name 
                  FROM activity_logs al
                  JOIN accounts a ON al.account_id = a.account_id";
$activityResult = mysqli_query($conn, $activityQuery);


// Check if the query executed successfully and a row is returned
if ($activityResult && mysqli_num_rows($activityResult) > 0) {
    $activity = mysqli_fetch_assoc($activityResult);
}


    // Execute the SELECT query
    $result = mysqli_query($conn, $activityQuery);

    // Check if the query executed successfully
    if ($result) {

        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            // Display the activity logs
            while ($activity = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $activity['timestamp'] . '</td>'; 
            echo '<td>' . $activity['action'] . '</td>';
            echo '<td>' . $activity['user_id'] . '</td>';
            echo '<td>' . $activity['account_name'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<p>No profiles found.</p>';
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Display the MySQL error
    echo 'Query error: ' . mysqli_error($conn);
}
?>
