<?php
// Include database connection
require_once 'db_connect.php';

// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Retrieve the selected account ID from the session or URL parameter
$selectedAccountID = isset($_SESSION['selected_account']) ? $_SESSION['selected_account'] : null;

// Construct the SQL query to retrieve the logged-in user's account
$accountQuery = "SELECT au.account_id, a.account_name
                FROM account_users au
                JOIN accounts a ON au.account_id = a.account_id
                WHERE au.user_id = '$loggedInUserID'";

// Add a condition to filter by selected account ID, if available
if ($selectedAccountID) {
    $accountQuery .= " AND au.account_id = '$selectedAccountID'";
}

$accountResult = mysqli_query($conn, $accountQuery);

// Check if the query executed successfully and a row is returned
if ($accountResult && mysqli_num_rows($accountResult) > 0) {
    $account = mysqli_fetch_assoc($accountResult);
    $loggedInAccountID = $account['account_id'];
    $loggedInAccountName = $account['account_name'];

    // Construct the SQL query to retrieve archived items
    $query = "SELECT ai.id, ai.archived_at, ai.item_type, ai.item_id, a.account_name, u.username AS archived_by
              FROM archived_items ai
              JOIN account_users au ON ai.archived_by = au.user_id
              JOIN accounts a ON au.account_id = a.account_id
              JOIN users u ON ai.archived_by = u.id";

    // Add a condition to filter by logged-in account, if applicable
    if ($loggedInAccountName !== 'PSUBP') {
        $query .= " WHERE au.account_id = '$loggedInAccountID'";
    }

    // Execute the SELECT query
    $result = mysqli_query($conn, $query);

    echo '<tbody>';

    // Check if the query executed successfully
    if ($result) {
        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            // Display the archived items
            while ($archive = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($archive['archived_at']) . '</td>';
                echo '<td>' . htmlspecialchars($archive['item_type']) . '</td>';
                echo '<td>' . htmlspecialchars($archive['item_id']) . '</td>'; // Assuming item_id is the item name for simplicity
                echo '<td>' . htmlspecialchars($archive['account_name']) . '</td>';
                echo '<td>';
                echo '<div class="action-buttons">';
                echo '<button class="unarchive-button" data-id="' . $archive['id'] . '" data-type="' . $archive['item_type'] . '">Unarchive</button>';
                echo '<button class="delete-button" data-id="' . $archive['id'] . '" data-type="' . $archive['item_type'] . '">Delete</button>';
                echo '</div>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            // No archived items found
            echo '<tr><td colspan="5">No archived items found</td></tr>';
        }

        // Free the result set
        mysqli_free_result($result);
    } else {
        // Display the MySQL error
        echo '<tr><td colspan="5">Query error: ' . mysqli_error($conn) . '</td></tr>';
    }

    echo '</tbody>';

    // Free the account result set
    mysqli_free_result($accountResult);
} else {
    // No account found for the logged-in user
    echo 'No account found for the logged-in user.';
}

// Handle unarchive request
if (isset($_GET['unarchive_id'])) {
    $unarchiveId = $_GET['unarchive_id'];

    // Retrieve item details to update based on item_type
    $getItemQuery = "SELECT item_id, item_type FROM archived_items WHERE id = '$unarchiveId'";
    $itemResult = mysqli_query($conn, $getItemQuery);

    if ($itemResult && mysqli_num_rows($itemResult) > 0) {
        $item = mysqli_fetch_assoc($itemResult);
        $itemId = $item['item_id'];
        $itemType = $item['item_type'];

        // Adjust the update query based on item_type
        switch ($itemType) {
            case 'Post':
                $updateQuery = "UPDATE posts SET archived = 0 WHERE id = '$itemId'";
                break;
            case 'asset':
                $updateQuery = "UPDATE assets SET archived = 0 WHERE id = '$itemId'";
                break;
            case 'user':
                $updateQuery = "UPDATE users SET archived = 0 WHERE id = '$itemId'";
                break;
            // Add more cases as needed for different item types
            default:
                // Handle unknown item types or error cases
                echo "<script>alert('Unknown item type: " . $itemType . "');</script>";
                break;
        }

        // Execute the update query
        if (isset($updateQuery) && mysqli_query($conn, $updateQuery)) {
            // Delete the entry from archived_items
            $unarchiveQuery = "DELETE FROM archived_items WHERE id = '$unarchiveId'";
            if (mysqli_query($conn, $unarchiveQuery)) {
                echo "<script>alert('Item unarchived successfully.'); window.location.href = './manage_archive.php';</script>";
            } else {
                echo "<script>alert('Error deleting from archived items: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Error updating item: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Item not found in archived items.');</script>";
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // Delete the corresponding row from archived_items
    $deleteQuery = "DELETE FROM archived_items WHERE id = '$deleteId'";

    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Item deleted successfully.'); window.location.href = './manage_archive.php';</script>";
    } else {
        echo "<script>alert('Error deleting item: " . mysqli_error($conn) . "');</script>";
    }
}

// Close MySQL connection
mysqli_close($conn);
?>



<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.unarchive-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var itemType = this.getAttribute('data-type');
            if (confirm('Are you sure you want to unarchive this ' + itemType + '?')) {
                window.location.href = '?unarchive_id=' + id;
            }
        });
    });

    document.querySelectorAll('.delete-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var itemType = this.getAttribute('data-type');
            if (confirm('Are you sure you want to delete this ' + itemType + '?')) {
                window.location.href = '?delete_id=' + id;
            }
        });
    });
});
</script>
