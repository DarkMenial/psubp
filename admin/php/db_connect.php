<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'psubp_db';

// Establish a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die('Failed to connect to MySQL: ' . $conn->connect_error);
}
?>