<?php
// Set the timezone to "Asia/Manila" (Philippines)
date_default_timezone_set('Asia/Manila');
require_once 'db_connect.php';
require_once 'activity_logs.php'; 

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);


// Retrieve form data
$postId = isset($_POST['post_id']) ? $_POST['post_id'] : '';
$title = isset($_POST['title']) ? $_POST['title'] : '';
$topicId = isset($_POST['topic_id']) ? $_POST['topic_id'] : '';
$content = isset($_POST['content']) ? $_POST['content'] : '';
$image = isset($_FILES['image']) ? $_FILES['image'] : null; // Check if the image is set
$publish = isset($_POST['publish']) ? 1 : 0;
$autoArchive = isset($_POST['auto-archive']) ? 1 : 0;
$autoArchiveDate = isset($_POST['auto-archive-date']) ? $_POST['auto-archive-date'] : '';

// Get the logged-in author's user ID
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Retrieve the user ID based on the username
$userQuery = "SELECT id FROM users WHERE username = '$username'";
$userResult = mysqli_query($conn, $userQuery);

if ($userResult && mysqli_num_rows($userResult) > 0) {
    $userRow = mysqli_fetch_assoc($userResult);
    $userId = $userRow['id'];
} else {
    // Handle the case where user ID couldn't be retrieved
    echo "Error: Could not retrieve user ID.";
    exit;
}

// Validate and sanitize user input
$postId = mysqli_real_escape_string($conn, $postId);
$title = mysqli_real_escape_string($conn, $title);
$topicId = mysqli_real_escape_string($conn, $topicId);
$content = mysqli_real_escape_string($conn, $content);
$autoArchiveDate = mysqli_real_escape_string($conn, $autoArchiveDate);

// Check if required fields are provided
if (empty($postId) || empty($title) || empty($topicId) || empty($content)) {
    echo "Error: Please fill in all required fields.";
    exit;
}

// Handle the image upload and rename only if a new image is provided
$imagePath = '';
if ($image && $image['error'] === UPLOAD_ERR_OK) {
    // Specify the destination folder
    $destinationFolder = '../../public/posts/images/';

    // Generate a new file name based on the post title and date
    $currentDate = date('Y-m-d');
    $newFileName = $title . '_' . $currentDate;

    // Check if a file with the same name already exists
    $counter = 1;
    while (file_exists($destinationFolder . $newFileName . '.jpg')) {
        $newFileName = $title . '_' . $currentDate . '(' . $counter . ')';
        $counter++;
    }

    // Append the file extension
    $newFileName .= '.jpg';

    // Set the destination path with the new file name
    $destinationPath = $destinationFolder . $newFileName;

    // Move the uploaded file to the destination folder with the new file name
    if (move_uploaded_file($_FILES['image']['tmp_name'], $destinationPath)) {
        // File moved successfully
        echo "Image uploaded successfully!";
        $imagePath = $newFileName;
    } else {
        // Error occurred while moving the file
        echo "Error uploading image!";
        exit;
    }
} else {
    // If no new image was uploaded, retain the existing image path in the database
    $getImageQuery = "SELECT image FROM posts WHERE id = '$postId'";
    $getImageResult = mysqli_query($conn, $getImageQuery);
    if ($getImageResult && mysqli_num_rows($getImageResult) > 0) {
        $imageRow = mysqli_fetch_assoc($getImageResult);
        $imagePath = $imageRow['image'];
    } else {
        // Handle the case where the existing image path couldn't be retrieved
        echo "Error: Could not retrieve existing image path.";
        exit;
    }
}


// Retrieve the previous publish state of the post
$previousPublishStateQuery = "SELECT publish FROM posts WHERE id = '$postId'";
$previousPublishStateResult = mysqli_query($conn, $previousPublishStateQuery);

if ($previousPublishStateResult && mysqli_num_rows($previousPublishStateResult) > 0) {
    $previousPublishStateRow = mysqli_fetch_assoc($previousPublishStateResult);
    $previousPublishState = $previousPublishStateRow['publish'];
    
    // Check if the post was previously published but is now being updated as not published
    if ($previousPublishState == 1 && $publish == 0) {
        // Record audit trail for unpublishing the post
        record_audit_trail($conn, $userId, 'unpublish_post', $postId);
    }
}

// Prepare the UPDATE statement
$sql = "UPDATE posts SET title=?, image=?, content=?, publish=?, auto_archive=?, auto_archive_date=?, topic_id=?, publisher_id=? WHERE id=?";

// Create a prepared statement
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, 'sssiisiii', $title, $imagePath, $content, $publish, $autoArchive, $autoArchiveDate, $topicId, $userId, $postId);

// Execute the prepared statement
if (mysqli_stmt_execute($stmt)) {
    // Check if any changes were made to the post
    $changesMade = mysqli_stmt_affected_rows($stmt) > 0;

    // Data updated successfully
    // echo "Post updated successfully!";
    $userId = $_SESSION['id'];
    $accountId = $_SESSION['selected_account'];

    // Log the logout activity along with device information
    $logMessage = "User Edited a Post";
    logActivity('edit_post', $logMessage, $userId, $accountId);
header("Location: ../manage_posts.php");


    
    // Record audit trail for post update if changes were made
    if ($changesMade) {
        record_audit_trail($conn, $userId, 'edit_post', $postId);
        
        // If the post is published and changes were made, record audit trail for post publish
        if ($publish == 1) {
            record_audit_trail($conn, $userId, 'publish_post', $postId);
        }
    }
} else {
    // Error occurred while preparing the statement
    echo "Error: " . mysqli_error($conn);
    exit;
}


    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);


// Function to record audit trail
function record_audit_trail($conn, $userId, $action, $postId) {
    // Prepare and execute the INSERT statement
    $query = "INSERT INTO audit_trail (user_id, action, post_id, timestamp) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'isi', $userId, $action, $postId);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    // Check if the INSERT was successful
    if ($success) {
        echo "Audit trail recorded successfully!";
    } else {
        echo "Failed to record audit trail!";
    }
}
?>
