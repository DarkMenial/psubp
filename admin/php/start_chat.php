<?php
// Database connection
require 'db_connection.php'; // Update with your database connection script

header('Content-Type: application/json');

// Get the JSON payload
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['user_name'], $data['user_email'], $data['department'])) {
    $userName = $data['user_name'];
    $userEmail = $data['user_email'];
    $department = $data['department'];

    // Prepare SQL to insert into `chat_users` table
    $sql = "INSERT INTO chat_users (name, email, department_id, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$userName, $userEmail, $department])) {
        // Get the last inserted ID (assuming it’s the chat ID)
        $chatId = $conn->lastInsertId();

        // Respond with success and the chat ID
        echo json_encode(['success' => true, 'chat_id' => $chatId]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}
