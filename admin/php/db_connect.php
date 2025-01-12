<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'psubp_db';
date_default_timezone_set('Asia/Manila'); // Adjust as per your region


// Establish a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die('Failed to connect to MySQL: ' . $conn->connect_error);
}


?>
