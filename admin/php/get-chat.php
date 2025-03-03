<?php
session_start();
include_once "db_connect.php";

$chat_id = $_GET['chat_id'] ?? $_SESSION['chat_id'] ?? '';
$userId = $_SESSION['id']; // Assuming 'id' is the user ID

echo "<br>Session Chat ID: " . $_SESSION['chat_id'];
echo "<br>Chat ID from Request: " . ($_GET['chat_id'] ?? 'None');

$sql = "SELECT chat_id FROM chat_sessions WHERE chat_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $chat_id);
$stmt->execute();
$result = $stmt->get_result();
$chat_data = $result->fetch_assoc();

echo "<br>Database Chat ID: " . ($chat_data['chat_id'] ?? 'Not Found');



if (!empty($chat_id)) {
    // Update last activity
    $update_sql = "UPDATE chat_sessions SET last_activity = NOW() WHERE chat_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("s", $chat_id);
    $update_stmt->execute();

    // Check if session is still active
    $sql = "SELECT chat_id, status FROM chat_sessions WHERE chat_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $chat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $chat_data = $result->fetch_assoc();

    if ($chat_data['status'] === 'closed') {
        echo "<div class='chat-info'>This chat has been closed. You can no longer send messages.</div>";
        exit();
    }

    // Fetch chat messages without bot
    // $sql = "SELECT sender, message, sent_at 
    // FROM chat_messages 
    // WHERE chat_id = ? AND sender <> 'Bot' 
    // ORDER BY sent_at ASC";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("s", $chat_id);
    // $stmt->execute();
    // $result = $stmt->get_result();


    // Fetch chat messages with bot
    $sql = "SELECT sender, message, sent_at FROM chat_messages WHERE chat_id = ? ORDER BY sent_at ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $chat_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $sender = htmlspecialchars($row['sender']);
        $message = htmlspecialchars($row['message']);
        $timestamp = date("h:i A", strtotime($row['sent_at'])); // Format time

        
        // Determine message alignment
        if ($sender === "User") {
            $cssClass = "outgoing";
        } elseif ($sender === "Bot") { 
            $cssClass = "bot-message"; // Add a unique class for bot messages
        } elseif ($userId && $sender === $userId) {
            $cssClass = "staff-message";
        } else {
            $cssClass = "incoming";
        }
        
        echo "<div class='chat $cssClass'>";
        echo "<div class='message-content'>";
        echo "<span class='chat-sender'>$sender</span>";
        echo "<p>$message</p>";
        echo "<span class='timestamp'>$timestamp</span>";
        echo "</div>";
        echo "</div>";
    }
}
?>


