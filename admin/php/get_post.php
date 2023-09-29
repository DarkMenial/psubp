<?php

require_once 'db_connect.php';

// Retrieve form data
$title = $_POST['title'];
$topic = $_POST['topic'];
$image = isset($_FILES['image']) ? $_FILES['image'] : null; // Check if the image is set
$content = $_POST['content'];
$publish = isset($_POST['publish']) ? 1 : 0;
$autoArchive = isset($_POST['auto-archive']) ? 1 : 0;
$autoArchiveDate = isset($_POST['auto-archive-date']) ? $_POST['auto-archive-date'] : '';
$startDate = $_POST['start-date'];
$endDate = $_POST['end-date'];
$datePosted = date('Y-m-d');

// Validate and sanitize user input
$title = mysqli_real_escape_string($conn, $title);
$topic = mysqli_real_escape_string($conn, $topic);
$content = mysqli_real_escape_string($conn, $content);
$autoArchiveDate = mysqli_real_escape_string($conn, $autoArchiveDate);
$startDate = mysqli_real_escape_string($conn, $startDate);
$endDate = mysqli_real_escape_string($conn, $endDate);

// Check if required fields are provided
if (empty($title) || empty($topic) || empty($content)) {
    echo "Error: Please fill in all required fields.";
    exit;
}

// Handle the image upload and rename
$imagePath = '';
if ($image && $image['error'] === UPLOAD_ERR_OK) {
    // Specify the destination folder
    $destinationFolder = '../../../public/posts/';

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
}

// Prepare the INSERT statement
$sql = "INSERT INTO posts (title, topic, image, content, publish, auto_archive, auto_archive_date, start_date, end_date, date_posted) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Create a prepared statement
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, 'ssssiiisss', $title, $topic, $imagePath, $content, $publish, $autoArchive, $autoArchiveDate, $startDate, $endDate, $datePosted);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Data inserted successfully
        echo "Post created successfully!";

        // Retrieve the newly inserted post data
        $insertedId = mysqli_insert_id($conn);
        $result = mysqli_query($conn, "SELECT image, title, content, topic, date_posted FROM posts WHERE id = $insertedId");

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            echo '<div class="card">';
            echo '<img src="' . $row['image'] . '" alt="Announcement Image" class="card-image">';
            echo '<div class="card-content">';
            echo '<h3 class="card-title">' . $row['title'] . '</h3>';
            echo '<p class="card-type">' . $row['topic'] . '</p>';
            echo '<p class="card-date">' . $row['date_posted'] . '</p>';
            echo '<p>' . $row['content'] . '</p>';
            echo '</div>';
            echo '</div>';
        }
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
    $result = mysqli_query($conn, "SELECT image FROM posts WHERE id = $postId");

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['image'];

        // Specify the destination folder
        $destinationFolder = '../../../public/posts/';

        // Delete the image file
        if (!empty($imagePath) && file_exists($destinationFolder . $imagePath)) {
            if (unlink($destinationFolder . $imagePath)) {
                echo "Image deleted successfully!";
            } else {
                echo "Error deleting image file!";
                exit;
            }
        }
    }

    // Delete the row from the table
    $deleteResult = mysqli_query($conn, "DELETE FROM posts WHERE id = $postId");

    if ($deleteResult) {
        echo "Post deleted successfully!";
    } else {
        echo "Error deleting post: " . mysqli_error($conn);
    }
}

?>