<?php
require_once './admin/php/db_connect.php';
session_start(); // Start the session


// Check if the chat user is already stored in the session
if (!isset($_SESSION['chat_user'])) {
    echo "<p>You need to start a chat first.</p>";
    exit();
}

$chat_user = $_SESSION['chat_user'];
$chat_id = $_GET['chat_id'] ?? null;

if ($chat_id) {
    echo "<main class='page-wrapper'>
            <div class='lg-box'>
                <h1 class='chat-room-title'>Chat Room #$chat_id</h1>";

    // Fetch chat messages for this chat room
    $sql = "SELECT cm.id, cm.sender_type, 
        IF(cm.sender_type = 'user', u.name, p.name) AS sender_name,
        cm.message, cm.sent_at
        FROM chat_messages cm
        LEFT JOIN chat_users u ON cm.user_sender_id = u.id AND cm.sender_type = 'user'
        LEFT JOIN users us ON cm.admin_sender_id = us.id AND cm.sender_type = 'admin' 
        LEFT JOIN profiles p ON us.profile_id = p.id
        WHERE cm.chat_room_id = '$chat_id'
        ORDER BY cm.sent_at ASC";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sender_name = $row['sender_name'] ?? 'Unknown Sender';
            $message = htmlspecialchars($row['message']);
            $sent_at = $row['sent_at'];
            $sender_type = $row['sender_type'];

            // Display messages with appropriate styling
            if ($sender_type == 'admin') {
                echo "<div class='message'>
                        <div class='message-admin'>
                            <strong>$sender_name</strong> <small class='message-time'>($sent_at)</small>: <p>$message</p>
                        </div>
                      </div>";
            } else {
                echo "<div class='message'>
                        <div class='message-user'>
                            <strong>$sender_name</strong> <small class='message-time'>($sent_at)</small>: <p>$message</p>
                        </div>
                      </div>";
            }
        }
    } else {
        echo "<p>No messages yet in this chat room.</p>";
    }

    // Display message input form
    echo "
    <form method='POST' class='message-form'>
        <textarea name='message' placeholder='Type your message...' required></textarea><br>
        <button type='submit' name='send_message'>Send</button>
    </form>";

    // Handle new message submission
    if (isset($_POST['send_message'])) {
        $message = $_POST['message'];
        $sender_type = 'user'; // User is sending the message
        $user_id = $_SESSION['chat_user']['user_id']; // Retrieve user ID from session

        $user_sender_id = $user_id;
        $admin_sender_id = NULL;

        // Prepare the SQL statement using placeholders
        $sqlInsert = $conn->prepare("INSERT INTO chat_messages (chat_room_id, sender_type, user_sender_id, admin_sender_id, message) 
                                    VALUES (?, ?, ?, ?, ?)");

        // Bind parameters to the prepared statement
        $sqlInsert->bind_param("ssiis", $chat_id, $sender_type, $user_sender_id, $admin_sender_id, $message);

        // Execute the query and check for success
        if ($sqlInsert->execute()) {
            // Redirect to refresh the chat room
            echo '<script type="text/javascript">
                    window.location.href = "chat.php?chat_id=' . $chat_id . '";
                  </script>';
            exit();
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }

        // Close the prepared statement
        $sqlInsert->close();
    }

    echo "</div></main>";
} else {
    echo "<p>No chat session found.</p>";
}

$conn->close();
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
