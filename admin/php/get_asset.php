<?php
require_once 'db_connect.php';

// Get the logged-in user's ID from session
session_start();
$loggedInUserID = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Function to change an asset and handle file upload
function changeAsset($assetId, $conn, $loggedInUserID) {
    // Fetch the asset details
    $assetQuery = "SELECT * FROM assets WHERE id = '$assetId'";
    $assetResult = mysqli_query($conn, $assetQuery);
    $asset = mysqli_fetch_assoc($assetResult);

    // Check if form was submitted and file uploaded
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
        // File upload handling
        $uploadDirectory = '../../public/assets/'; // Update with your upload directory

        // Check if the upload directory exists
        if (!is_dir($uploadDirectory)) {
            echo "Upload directory does not exist.";
            return;
        }

        // File details
        $file = $_FILES['file'];

        // Debug: Output file details
        echo '<pre>';
        var_dump($file);
        echo '</pre>';

        // Check for file errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo "Error uploading file. Error code: " . $file['error'];
            return;
        }

        // Generate a unique filename to prevent overwriting existing files
        $filename = uniqid('asset_') . '_' . $file['name'];
        $destinationPath = $uploadDirectory . $filename;

        // Debug: Output destination path
        echo "Destination path: $destinationPath<br>";

        // Move uploaded file to destination directory
        if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
            echo "Error moving uploaded file.";
            return;
        }

        // Update the asset record in the database
        $updateQuery = "UPDATE assets SET file_name = '$filename' WHERE id = '$assetId'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            echo "Asset changed and uploaded successfully.";
        } else {
            echo "Error updating asset in database: " . mysqli_error($conn);
        }
    }
}

// Check if 'change_id' is set in URL
if (isset($_GET['change_id'])) {
    $changeId = $_GET['change_id'];
    changeAsset($changeId, $conn, $loggedInUserID);
}


// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Function to check if user has a specific account
function hasAccount($userID, $accountName) {
    global $conn;

    $sql = "SELECT a.account_name 
            FROM users u
            JOIN account_users au ON u.id = au.user_id
            JOIN accounts a ON au.account_id = a.account_id
            WHERE u.id = '$userID'";

    $result = mysqli_query($conn, $sql);

    $userAccounts = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userAccounts[] = $row['account_name'];
        }
    }

    return in_array($accountName, $userAccounts);
}

// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Check if user has the 'PSUBP' account
$hasPSUBPAccount = hasAccount($loggedInUserID, 'PSUBP');

// Redirect if the user does not have the 'PSUBP' account
if (!$hasPSUBPAccount) {
    echo '<script>window.location.href = "../dashboard.php";</script>';
    exit();
}


// Close MySQL connection
mysqli_close($conn);


?>
