<?php
session_start();
include_once "php/db_connect.php";

// Force the chat ID to be taken only from the URL
$chat_id = $_GET['chat_id'] ?? '';

if (empty($chat_id)) {
    echo "<div class='chat-info'>No chat session selected.</div>";
    exit();
}

// Debugging outputs (optional)
echo "<br>Chat ID from URL: " . ($_GET['chat_id'] ?? 'None');

// Check if chat session exists
$sql = "SELECT chat_id, status FROM chat_sessions WHERE chat_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $chat_id);
$stmt->execute();
$result = $stmt->get_result();
$chat_data = $result->fetch_assoc();

if (!$chat_data) {
    echo "<div class='chat-info'>Chat session not found.</div>";
    exit();
}

// Update last activity timestamp
$update_sql = "UPDATE chat_sessions SET last_activity = NOW() WHERE chat_id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("s", $chat_id);
$update_stmt->execute();

// If chat is closed, show a message
if ($chat_data['status'] === 'closed') {
    echo "<div class='chat-info'>This chat has been closed. You can no longer send messages.</div>";
    exit();
}

// Fetch chat messages
$sql = "SELECT sender, message, sent_at FROM chat_messages WHERE chat_id = ? ORDER BY sent_at ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $chat_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $sender = htmlspecialchars($row['sender']);
    $message = htmlspecialchars($row['message']);
    $timestamp = date("h:i A", strtotime($row['sent_at']));

    // Determine message alignment
    $cssClass = ($sender === "User") ? "outgoing" : "incoming";

    echo "<div class='chat $cssClass'>";
    echo "<div class='message-content'>";
    echo "<span class='chat-sender'>$sender</span>";
    echo "<p>$message</p>";
    echo "<span class='timestamp'>$timestamp</span>";
    echo "</div>";
    echo "</div>";
}
?>

<style>
/* Chat room title */
.chat-room-title {
  font-size: 24px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

/* Chat message container */
.message {
  margin-bottom: 15px;
  /* padding: 10px; */
  /* border: 1px solid #ccc; */
  /* border-radius: 8px; */
  /* background-color: white; */
  max-width: 100%;
  word-wrap: break-word;
  display: flex;
  flex-direction: column;
  z-index: 0;
}

.message-user {
  align-self: flex-start; /* Align user messages to the left */
  background-color: #f0f0f0;
  border-color: #d1d1d1;
  text-align: left;
  align-items: right;
  padding: 15px;  
}

.message-admin {
  align-self: flex-end; /* Align admin messages to the right */
  background-color: #e4f1f5; /* Light background for admin */
  border-color: #b5e0eb;
  text-align: right;
  align-items: right;
  padding: 15px;  
}

.message strong {
  color: #333;
  font-size: 16px;
}

.message-time {
  font-size: 12px;
  color: #666;
}

/* Message input form */
.message-form {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
}

textarea {
  width: 80%;
  height: 100px;
  padding: 12px;
  border-radius: 8px;
  border: 1px solid #ccc;
  resize: none;
  font-size: 14px;
}

button {
  padding: 12px 25px;
  background-color: #f05c26;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  margin-top: 10px;
}

button:hover {
  background-color: #e04a20;
}

/* Responsive Design */
@media (max-width: 768px) {
  .message {
    max-width: 90%;
  }

  .message-form textarea {
    width: 90%;
  }

  button {
    width: 90%;
  }
}

</style>
