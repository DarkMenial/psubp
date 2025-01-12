<?php
require_once 'db_connect.php';
session_start();
require_once 'activity_logs.php'; 


ini_set('display_errors', 1);
error_reporting(E_ALL);

// Retrieve form data
$name = $_POST['name'];
$position = $_POST['position'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$bio = $_POST['bio'];
$photo = $_FILES['image'];  // Uploaded file data

// Validate and sanitize user input
$name = mysqli_real_escape_string($conn, $name);
$position = mysqli_real_escape_string($conn, $position);
$email = mysqli_real_escape_string($conn, $email);
$phone = mysqli_real_escape_string($conn, $phone);
$bio = mysqli_real_escape_string($conn, $bio);

// Handle the image upload and rename
$imagePath = '';
if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
    // Specify the destination folder
    $destinationFolder = '../../../psubp/public/profiles/';

    // Generate a new file name based on the user's name
    $newFileName = $name;

    // Check if a file with the same name already exists
    $counter = 1;
    $fileExtension = pathinfo($photo['name'], PATHINFO_EXTENSION);
    while (file_exists($destinationFolder . $newFileName . '.' . $fileExtension)) {
        $newFileName = $name . '_' . $counter;
        $counter++;
    }

    // Set the destination path with the new file name and extension
    $newFileName = $newFileName . '.' . $fileExtension;
    $destinationPath = $destinationFolder . $newFileName;

    // Move the uploaded file to the destination folder with the new file name
    if (move_uploaded_file($photo['tmp_name'], $destinationPath)) {
        // File moved successfully
        echo "Image uploaded successfully!";
        $imagePath = $newFileName;
    } else {
        // Error occurred while moving the file
        echo "Error uploading image!";
        exit;
    }
}

// Prepare the INSERT statement
$sql = "INSERT INTO profiles (name, position, email, phone, bio, photo) 
        VALUES (?, ?, ?, ?, ?, ?)";

// Create a prepared statement
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, 'sssiss', $name, $position, $email, $phone, $bio, $imagePath);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Data inserted successfully
        echo "Profile Added!";
            $userId = $_SESSION['id'];
    $accountId = $_SESSION['selected_account'];

    // Log the logout activity along with device information
    $logMessage = "User Added A Profile";
    logActivity('create_profile', $logMessage, $userId, $accountId);
        // Retrieve the newly inserted post data
        $insertedId = mysqli_insert_id($conn);
        $result = mysqli_query($conn, "SELECT name, position, email, phone, bio, photo FROM profiles WHERE id = $insertedId");
    } else {
        // Error occurred while inserting data
        echo "Error: " . mysqli_stmt_error($stmt);
        exit;
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    // Error occurred while preparing the statement
    echo "Error: " . mysqli_error($conn);
    exit;
}

// Close the database connection
mysqli_close($conn);

// Function to sanitize the filename (remove spaces, special characters, etc.)
function sanitizeFilename($filename) {
    // Implement your own logic to sanitize the filename
    // Example: remove spaces and special characters
    $sanitized = preg_replace('/[^A-Za-z0-9\-]/', '', $filename);
    return $sanitized;
}

// Delete the image file if a row is deleted from the table
if (isset($_POST['delete'])) {
    $postId = $_POST['delete'];

    // Retrieve the image path for the post
    $result = mysqli_query($conn, "SELECT photo FROM profiles WHERE id = $postId");

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['photo'];

        // Specify the destination folder
        $destinationFolder = '../../profiles/';

        // Delete the image file
        if (!empty($imagePath) && file_exists($destinationFolder . $imagePath)) {
            unlink($destinationFolder . $imagePath);
        }
    }

    // Delete the row from the table
    $deleteResult = mysqli_query($conn, "DELETE FROM profiles WHERE id = $postId");

    if ($deleteResult) {
        echo "Profile deleted successfully!";
    } else {
        echo "Error deleting profile: " . mysqli_error($conn);
    }
}
?>
