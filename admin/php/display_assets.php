<?php
require_once 'db_connect.php';

$loggedInUserID = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Retrieve the selected account ID from session or URL parameter
$selectedAccountID = isset($_SESSION['selected_account']) ? $_SESSION['selected_account'] : null;

// Function to delete an asset
function deleteAsset($assetId, $conn) {
    $deleteQuery = "DELETE FROM assets WHERE id = '$assetId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "Asset deleted successfully.";
    } else {
        echo "Error deleting asset: " . mysqli_error($conn);
    }
}

// Check if 'delete_id' is set in URL
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    deleteAsset($deleteId, $conn);
}

// Function to check if a user has a specific permission
function hasPermission($userID, $permissionName, $conn) {
    $sql = "SELECT p.name AS permission_name 
            FROM users u
            JOIN user_permissions up ON u.id = up.user_id
            JOIN permissions p ON up.permission_id = p.id
            WHERE u.id = '$userID' AND p.name = '$permissionName'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    }

    return false;
}

// Retrieve user's account information
$accountQuery = "SELECT au.account_id, a.account_name
                FROM account_users au
                JOIN accounts a ON au.account_id = a.account_id
                WHERE au.user_id = '$loggedInUserID'";

// Filter by selected account ID, if available
if ($selectedAccountID) {
    $accountQuery .= " AND au.account_id = '$selectedAccountID'";
}

$accountResult = mysqli_query($conn, $accountQuery);

// Check if the query executed successfully and a row is returned
if ($accountResult && mysqli_num_rows($accountResult) > 0) {
    $account = mysqli_fetch_assoc($accountResult);
    $loggedInAccountID = $account['account_id'];
    $loggedInAccountName = $account['account_name'];

    // Construct the SQL query to retrieve assets
    $query = "SELECT a.id, a.asset_type, a.asset_category, a.account_id, acc.account_name, a.file_name
              FROM assets a
              JOIN accounts acc ON a.account_id = acc.account_id";

    // If the logged-in account is not PSUBP, add the account filter condition
    if ($loggedInAccountName !== 'PSUBP') {
        $query .= " WHERE a.account_id = '$loggedInAccountID'";
    }

    // Execute the SELECT query
    $result = mysqli_query($conn, $query);

    // Display the assets
    if ($result) {
        // Initialize an array to store assets
        $assets = [];

        // Fetch assets from database if available
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $assets[] = $row;
            }
            mysqli_free_result($result);
        }

        // Display the assets in HTML table rows
        if (!empty($assets)) {
            foreach ($assets as $asset) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($asset['asset_type']) . '</td>';
                echo '<td>' . htmlspecialchars($asset['asset_category']) . '</td>';
                echo '<td>' . htmlspecialchars($asset['account_name']) . '</td>';
                echo '<td>';

                $isAdmin = hasPermission($loggedInUserID, 'admin', $conn);

                if ($isAdmin || $loggedInAccountName === 'PSUBP') {
                    // Show all buttons for admin or PSUBP account
                    echo '<button class="change-asset-button" onclick="document.getElementById(\'file-input-' . $asset['id'] . '\').click();">Change Asset</button>';
                    echo '<form id="upload-form-' . $asset['id'] . '" method="POST" enctype="multipart/form-data" action="php/get_asset.php?change_id=' . $asset['id'] . '" style="display:none;">';
                    echo '<input type="file" id="file-input-' . $asset['id'] . '" name="file" onchange="document.getElementById(\'upload-form-' . $asset['id'] . '\').submit();">';
                    echo '<input type="hidden" name="asset_id" value="' . $asset['id'] . '">';
                    echo '</form>';
                    echo '<button class="delete-button" onclick="if(confirm(\'Are you sure you want to delete this asset?\')) window.location.href=\'display_assets.php?delete_id=' . $asset['id'] . '\'">Delete</button>';
                } else {
                    // Check for individual permissions if not admin or PSUBP account
                    if (hasPermission($loggedInUserID, 'change_asset', $conn) && $asset['account_id'] == $loggedInAccountID) {
                        echo '<button class="change-asset-button" onclick="document.getElementById(\'file-input-' . $asset['id'] . '\').click();">Change Asset</button>';
                        echo '<form id="upload-form-' . $asset['id'] . '" method="POST" enctype="multipart/form-data" action="php/get_asset.php?change_id=' . $asset['id'] . '" style="display:none;">';
                        echo '<input type="file" id="file-input-' . $asset['id'] . '" name="file" onchange="document.getElementById(\'upload-form-' . $asset['id'] . '\').submit();">';
                        echo '<input type="hidden" name="asset_id" value="' . $asset['id'] . '">';
                        echo '</form>';
                    }
                    if (hasPermission($loggedInUserID, 'delete_asset', $conn) && $asset['account_id'] == $loggedInAccountID) {
                        echo '<button class="delete-button" onclick="if(confirm(\'Are you sure you want to delete this asset?\')) window.location.href=\'display_assets.php?delete_id=' . $asset['id'] . '\'">Delete</button>';
                    }
                }

                echo '</td>';
                echo '</tr>';
            }
        } else {
            // No assets found
            echo '<tr><td colspan="4">No assets found.</td></tr>';
        }
    } else {
        // Query failed
        echo '<tr><td colspan="4">Failed to fetch assets.</td></tr>';
    }

    // Free the account result set
    mysqli_free_result($accountResult);
} else {
    // No account found for the logged-in user
    echo 'No account found for the logged-in user.';
}

// Close MySQL connection
mysqli_close($conn);
?>
