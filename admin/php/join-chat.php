<?php
session_start();
include_once "db_connect.php";

// Debugging: Force error display
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ensure JSON response
header('Content-Type: application/json');

// Prevent unexpected output
ob_start();

if (!isset($_SESSION['id']) || !isset($_POST['chat_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$staff_id = $_SESSION['id']; 
$chat_id = $_POST['chat_id'];

// Debugging: Log incoming data
error_log("Received chat_id: $chat_id from staff_id: $staff_id");

// Check if chat exists
$sql = "SELECT status, assigned_staff_id FROM chat_sessions WHERE chat_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $chat_id);
$stmt->execute();
$result = $stmt->get_result();
$chat = $result->fetch_assoc();



if (!$chat) {
    echo json_encode(["error" => "Chat session not found."]);
    exit();
}

error_log("Chat status: " . $chat['status']);

if ($chat['status'] !== 'open') {
    echo json_encode(["error" => "Chat already assigned."]);
    exit();
}

// Assign staff to chat
$sql = "UPDATE chat_sessions SET assigned_staff_id = ?, status = 'assigned', staff_joined_at = NOW() WHERE chat_id = ? AND status = 'open'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $staff_id, $chat_id);
$stmt->execute();




if ($stmt->affected_rows > 0) {
    error_log("Chat assigned successfully.");

    // Insert bot message
    $bot_message = "A staff member has joined the chat.";
    $sql = "INSERT INTO chat_messages (chat_id, sender, message) VALUES (?, 'Bot', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $chat_id, $bot_message);
    $stmt->execute();

    error_log("Bot message added.");

    // Ensure no unexpected output
    ob_clean();
    echo json_encode(["success" => true, "chat_url" => "staff-chat.php?chat_id=$chat_id"]);
    exit();
} else {
    error_log("Chat assignment failed.");
    echo json_encode(["error" => "Failed to join chat."]);
}
?>
