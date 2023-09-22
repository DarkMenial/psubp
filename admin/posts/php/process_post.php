<?php
// Connect to the database (replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "psu_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare the SELECT statement
$sql = "SELECT * FROM posts";

// Execute the SELECT statement
$result = mysqli_query($conn, $sql);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // Loop through the rows and display the data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Title: " . $row['title'] . "<br>";
        echo "Topic: " . $row['topic'] . "<br>";
        echo "Image: " . $row['image'] . "<br>";
        echo "Content: " . $row['content'] . "<br>";
        echo "Publish: " . $row['publish'] . "<br>";
        echo "Auto Archive: " . $row['auto_archive'] . "<br>";
        echo "Auto Archive Date: " . $row['auto_archive_date'] . "<br>";
        echo "Start Date: " . $row['start_date'] . "<br>";
        echo "End Date: " . $row['end_date'] . "<br>";
        echo "<hr>";
    }
} else {
    echo "No posts found.";
}

// Close the database connection
mysqli_close($conn);
?>
