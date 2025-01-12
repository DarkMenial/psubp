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

    // Construct the SQL query based on the filter values, excluding archived users
    $query = "SELECT u.id, p.name AS full_name, u.username, p.email, a.account_name, GROUP_CONCAT(perm.name SEPARATOR ', ') AS permissions
              FROM users u
              JOIN account_users au ON u.id = au.user_id
              JOIN accounts a ON au.account_id = a.account_id
              JOIN profiles p ON u.profile_id = p.id
              LEFT JOIN user_permissions up ON u.id = up.user_id
              LEFT JOIN permissions perm ON up.permission_id = perm.id";

    // Add the account filter condition if a specific account is selected
    if ($loggedInAccountName !== 'PSUBP') {
        $query .= " WHERE au.account_id = '$loggedInAccountID'";
    }

    // Group by user information to avoid duplicate rows
    $query .= " GROUP BY u.id";

    // Execute the SELECT query
    $result = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($result) {
        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            // Display the users
            while ($user = mysqli_fetch_assoc($result)) {
                echo '<tr>';

                echo '<td>';
                echo '<span style="opacity: 0.9; font-size: 13px;">' . $user['username'] . '</span>';
                echo '</td>';

                echo '<td>' . $user['full_name'] . '</td>';
                echo '<td>' . $user['email'] . '</td>';
                echo '<td>' . strtoupper($user['account_name']) . '</td>'; 
                echo '<td>' . $user['permissions'] . '</td>'; // Display permissions
                echo '<td>';
                echo ' <div class="action-buttons">';
                echo '<a href="./edit_user.php?id=' . $user['id'] . '" class="edit-link">';
                echo '<button class="edit-button">Edit</button>';
                echo '</a>';
                echo '<button class="archive-button" onclick="archiveUser(' . $user['id'] . ')">Archive</button>';
                echo '<button class="delete-button" onclick="deleteUser(' . $user['id'] . ')">Delete</button>';
                echo ' </div>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            // No users found
            echo '<tr><td colspan="5">No users found</td></tr>';
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
?>
