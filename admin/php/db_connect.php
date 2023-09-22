<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'psubp_db';

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Perform a simple test query
    $stmt = $conn->query("SELECT * FROM accounts LIMIT 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($result);  // Print the result to confirm the connection

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
