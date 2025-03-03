<?php
session_start();
include_once "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $chat_id = $_POST['chat_id'] ?? $_SESSION['chat_id'] ?? '';
    $message = trim($_POST['message']);
    $sender = $_POST['sender'] ?? 'User'; 
    $sender = $_POST['sender'] ?? 'Staff'; 


    if (!empty($chat_id) && !empty($message)) {

        // Insert message into the database
        $sql = "INSERT INTO chat_messages (chat_id, sender, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $chat_id, $sender, $message);
        $stmt->execute();

        // Check if staff is assigned
        $sql = "SELECT assigned_staff_id FROM chat_sessions WHERE chat_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $chat_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $chat_data = $result->fetch_assoc();

        // If no staff is assigned and user requests staff, notify them
        if (!$chat_data['assigned_staff_id'] && strtolower($message) === "i need to talk to a person.") {
            $bot_message = "A request for staff has been sent. Please wait for an available staff member.";
            
            // Insert bot message
            $sql = "INSERT INTO chat_messages (chat_id, sender, message) VALUES (?, 'Bot', ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $chat_id, $bot_message);
            $stmt->execute();
        }
    }
}
?>
