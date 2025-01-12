<?php
// Set the timezone to "Asia/Manila" (Philippines)
date_default_timezone_set('Asia/Manila');
session_start();
require_once 'db_connect.php';
require_once 'activity_logs.php'; 

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Output device timezone
echo "Device timezone: " . date_default_timezone_get() . "<br>";

// Set the timezone to the device's timezone
date_default_timezone_set(date_default_timezone_get());

// Output PHP's timezone
echo "PHP timezone: " . date_default_timezone_get() . "<br>";


// Retrieve form data
$title = isset($_POST['title']) ? $_POST['title'] : '';
$topicId = isset($_POST['topic_id']) ? $_POST['topic_id'] : '';
$content = isset($_POST['content']) ? $_POST['content'] : '';
$image = isset($_FILES['image']) ? $_FILES['image'] : null; // Check if the image is set
$publish = isset($_POST['publish']) ? 1 : 0;
$autoArchive = isset($_POST['auto-archive']) ? 1 : 0;
$autoArchiveDate = isset($_POST['auto-archive-date']) ? $_POST['auto-archive-date'] : '';
$datePosted = date('Y-m-d');

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
$title = mysqli_real_escape_string($conn, $title);
$topicId = mysqli_real_escape_string($conn, $topicId);
$content = mysqli_real_escape_string($conn, $content);
$autoArchiveDate = mysqli_real_escape_string($conn, $autoArchiveDate);

// Check if required fields are provided
if (empty($title) || empty($topicId) || empty($content)) {
    echo "Error: Please fill in all required fields.";
    exit;
}

// Handle the image upload and rename
$imagePath = '';
if ($image && $image['error'] === UPLOAD_ERR_OK) {
    // Specify the destination folder
    $destinationFolder = '../../public/posts/images/';

    // Generate a new file name based on the post title and date
    $currentTimestamp = date('Ymd_His');
    $newFileName = $title . '_' . $currentTimestamp;

    // Append the file extension
    $newFileName .= '.jpg';

    // Check if a file with the same name already exists
    $counter = 1;
    while (file_exists($destinationFolder . $newFileName)) {
        $newFileName = $title . '_' . $currentTimestamp . '(' . $counter . ')';
        $newFileName .= '.jpg'; // Append the file extension again
        $counter++;
    }

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

$datePosted = date('Y-m-d H:i:s');  // Current date and time

// Determine whether the post should be archived (1 for archived, 0 for not archived)
$archived = isset($_POST['archive']) ? 1 : 0;

// Retrieve the selected account ID from the session
$selectedAccountID = $_SESSION['selected_account'];

// Define the SQL query
$sql = "INSERT INTO posts (title, image, content, publish, auto_archive, auto_archive_date, date_posted, topic_id, author_id, publisher_id, account_id, archived) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Create a prepared statement
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Determine the publisher_id
    $publisherId = $publish ? $userId : null;

    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, 'ssssissssiii', $title, $imagePath, $content, $publish, $autoArchive, $autoArchiveDate, $datePosted, $topicId, $userId, $publisherId, $selectedAccountID, $archived);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Data inserted successfully
        echo "Post created successfully!";
        

        // Retrieve the ID of the newly inserted post
        $insertedId = mysqli_insert_id($conn);
        
        // Check if the inserted ID is valid
        if ($insertedId > 0) {
            // Log the action to the audit trail
            $action = "create_post"; // Define the action performed
            $user_id = $userId; // Use the user ID obtained earlier
            $timestamp = date('Y-m-d H:i:s'); // Current timestamp
    
            // Prepare the INSERT statement for the audit trail
            $audit_sql = "INSERT INTO audit_trail (action, post_id, user_id, timestamp) VALUES (?, ?, ?, ?)";
            $audit_stmt = mysqli_prepare($conn, $audit_sql);
    
            if ($audit_stmt) {
                // Bind the parameters to the prepared statement
                mysqli_stmt_bind_param($audit_stmt, 'siis', $action, $insertedId, $user_id, $timestamp);
    
                // Execute the prepared statement
                if (mysqli_stmt_execute($audit_stmt)) {
                    // Audit trail entry inserted successfully
                    echo "Audit trail entry inserted successfully!";
                } else {
                    // Error occurred while inserting audit trail entry
                    echo "Error inserting audit trail entry: " . mysqli_error($conn);
                    exit;
                }
    
                // Close the prepared statement
                mysqli_stmt_close($audit_stmt);
            } else {
                // Error occurred while preparing the audit trail statement
                echo "Error preparing audit trail statement: " . mysqli_error($conn);
                exit;
            }

            // Check if the post is being published
if ($publish) {
    // Log the action to the audit trail
    $publish_action = "publish_post"; // Define the action performed
    $publish_timestamp = date('Y-m-d H:i:s'); // Current timestamp

    // Prepare the INSERT statement for the publish action in the audit trail
    $publish_audit_sql = "INSERT INTO audit_trail (action, post_id, user_id, timestamp) VALUES (?, ?, ?, ?)";
    $publish_audit_stmt = mysqli_prepare($conn, $publish_audit_sql);

    if ($publish_audit_stmt) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($publish_audit_stmt, 'siis', $publish_action, $insertedId, $user_id, $publish_timestamp);

        // Execute the prepared statement
        if (mysqli_stmt_execute($publish_audit_stmt)) {
            // Audit trail entry for publishing inserted successfully
            echo "Audit trail entry for publishing inserted successfully!";
        } else {
            // Error occurred while inserting audit trail entry for publishing
            echo "Error inserting audit trail entry for publishing: " . mysqli_error($conn);
            exit;
        }

        // Close the prepared statement
        mysqli_stmt_close($publish_audit_stmt);
    } else {
        // Error occurred while preparing the audit trail statement for publishing
        echo "Error preparing audit trail statement for publishing: " . mysqli_error($conn);
        exit;
    }
}

            
            // Retrieve post data
            $result = mysqli_query($conn, "SELECT p.image, p.title, p.content, t.topic_name, p.date_posted
            FROM posts p
            JOIN topics t ON p.topic_id = t.topic_id
            WHERE p.id = $insertedId");

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                // Create a new PHP file
                $title = $row['title'];
                $filename = str_replace(' ', '_', $title) . '.php';
                $filepath = '../../public/posts/' . $filename;

                $phpCode = generatePhpFileContent($row); // Call function to generate PHP file content

                // Create PHP file
                createPostFile($filename, $phpCode);

                echo "PHP file created successfully!";
            } else {
                // Handle the case where the post data couldn't be retrieved
                echo "Error: Could not retrieve post data.";
                exit;
            }
        } else {
            // Invalid post ID
            echo "Error: Invalid post ID.";
            exit;
        }
    } else {
        // Error occurred while preparing the statement
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Function to generate PHP file content
function generatePhpFileContent($row) {
    $phpCode = '<?php' . PHP_EOL;
    $phpCode .= 'include $_SERVER[\'DOCUMENT_ROOT\'] . \'/psubp/html_utils/header.php\';' . PHP_EOL;

    $phpCode .= 'echo \'</style>\';' . PHP_EOL;
    $phpCode .= 'echo \'<div class="section">\';' . PHP_EOL;
    $phpCode .= 'echo \'</div>\';' . PHP_EOL; 
    $phpCode .= 'echo \'<div class="section">\';' . PHP_EOL;
    $phpCode .= 'echo \'</div>\';' . PHP_EOL; 
    $phpCode .= 'echo \'<div class="container">\';' . PHP_EOL;
    $phpCode .= 'echo \'<div class="container-post-topic">\';' . PHP_EOL;
    $phpCode .= 'echo \'<h1>' . $row['topic_name'] . '</h1>\';' . PHP_EOL; 
    $phpCode .= 'echo \'</div>\';' . PHP_EOL; 
    
    $phpCode .= 'echo \'<div class="container__posts">\';' . PHP_EOL;
    $phpCode .= 'echo \'<div class="post-container-image">\';' . PHP_EOL;
    $phpCode .= 'echo \'<img src="../../../psubp/public/posts/images/' . $row['image'] . '" alt="Announcement Image">\';' . PHP_EOL;
    $phpCode .= 'echo \'</div>\';' . PHP_EOL;
    $phpCode .= 'echo \'<div class="post-container-content">\';' . PHP_EOL;
    $phpCode .= 'echo \'<h1>' . $row['title'] . '</h3>\';' . PHP_EOL;
    $phpCode .= 'echo \'<p>' . $row['date_posted'] . '</p>\';' . PHP_EOL;
    $phpCode .= 'echo \'<p>' . $row['content'] . '</p>\';' . PHP_EOL;
    $phpCode .= 'echo \'</div>\';' . PHP_EOL;
    $phpCode .= 'echo \'</div>\';' . PHP_EOL;
    $phpCode .= 'echo \'</div>\';' . PHP_EOL; 

    $phpCode .= 'include $_SERVER[\'DOCUMENT_ROOT\'] . \'/psubp/html_utils/footer.php\';' . PHP_EOL;
    $phpCode .= '?>';


    return $phpCode;
}

// Function to create a PHP file for the post
function createPostFile($filename, $content) {
    $filepath = '../../public/posts/' . $filename;

    if (file_put_contents($filepath, $content) !== false) {
        echo "PHP file created successfully!";
        $userId = $_SESSION['id'];
        $accountId = $_SESSION['selected_account'];
    
        // Log the logout activity along with device information
        $logMessage = "User Created a Post";
        logActivity('create_post', $logMessage, $userId, $accountId);
    } else {
        echo "Error creating PHP file!";
    }
}
?>
