<?php
require_once 'php/db_connect.php';
include './php/check_login.php';
include './admin_utils/admin_header.php';

<<<<<<< Updated upstream
// Get the chat room ID from the URL
$chat_id = $_GET['chat_id'] ?? null;
if ($chat_id) {
    echo "<main class='page-wrapper'>
            <div class='lg-box'>
                <h1 class='chat-room-title'>Chat Room #$chat_id</h1>";

    // Fetch chat messages for this chat room from the database
    $sql = "SELECT cm.id, cm.sender_type, 
            IF(cm.sender_type = 'user', u.name, p.name) AS sender_name,
            cm.message, cm.sent_at
            FROM chat_messages cm
            LEFT JOIN chat_users u ON cm.user_sender_id = u.id AND cm.sender_type = 'user'
            LEFT JOIN profiles p ON cm.admin_sender_id = p.id AND cm.sender_type = 'admin'
            WHERE cm.chat_room_id = '$chat_id'
            ORDER BY cm.sent_at ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sender_name = $row['sender_name'] ?? 'Unknown Sender';
            $message = htmlspecialchars($row['message']);
            $sent_at = $row['sent_at'];
            $sender_type = $row['sender_type'];

            // Wrap each message in a div with the appropriate class
            if ($sender_type == 'admin') {
              echo "<div class='message'>";
                echo "<div class='message-admin'>";
                echo "<strong>$sender_name</strong> <small class='message-time'>($sent_at)</small>: <p>$message</p>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "<div class='message'>";
                echo "<div class='message-user'>";
                echo "<strong>$sender_name</strong> <small class='message-time'>($sent_at)</small>: <p>$message</p>";
                echo "</div>";
                echo "</div>";
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
        $sender_type = 'admin'; // Admin is sending the message
        $sender_id = $_SESSION['id']; // Assuming the logged-in admin's ID is stored in session

        $user_sender_id = NULL;
        $admin_sender_id = $sender_id;

        // Prepare the SQL statement using placeholders
        $sqlInsert = $conn->prepare("INSERT INTO chat_messages (chat_room_id, sender_type, user_sender_id, admin_sender_id, message) 
                                    VALUES (?, ?, ?, ?, ?)");

        // Bind parameters to the prepared statement
        $sqlInsert->bind_param("ssiis", $chat_id, $sender_type, $user_sender_id, $admin_sender_id, $message);

        // Execute the query and check for success
        if ($sqlInsert->execute()) {
            // Redirect using JavaScript
            echo '<script type="text/javascript">
                    window.location.href = "chat.php?chat_id=' . $chat_id . '";
                  </script>';
            exit(); // Ensure that the script stops here after the redirect
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
=======
// Fetch all open chats with the account name instead of account_id
$sql = "SELECT chat_sessions.*, accounts.account_name 
        FROM chat_sessions 
        JOIN accounts ON chat_sessions.account_id = accounts.account_id 
        WHERE chat_sessions.status IN ('open', 'assigned') 
        ORDER BY chat_sessions.created_at ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$chats = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<main class='page-wrapper'>
    <div class='lg-box'>
        <?php
        // Debugging Info
        // echo "<pre>🔍 Debugging Info:<br>";
        // echo "Session: "; print_r($_SESSION);
        // echo "Cookies: "; print_r($_COOKIE);
        // echo "Database Chat Sessions: "; print_r($chats);
        // echo "</pre>";
        ?>
        
        <h2>Student Inquiries</h2>
        <ul>
            <?php foreach ($chats as $chat): ?>
                <li>
                    <span><?php echo htmlspecialchars($chat['user_name']); ?> (<?php echo htmlspecialchars($chat['account_name']); ?>)</span>
                    <button onclick="joinChat('<?php echo $chat['chat_id']; ?>')">Join Chat</button>
                    <button onclick="closeChat('<?php echo $chat['chat_id']; ?>')">Close Chat</button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</main>

<script>
function joinChat(chatId) {
  console.log("Joining chat:", chatId);
    fetch("php/join-chat.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `chat_id=${chatId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.chat_url; // Redirect to staff chat
        } else {
            alert("Error: " + data.error);
        }
    })
    .catch(error => {
        alert("Something went wrong: " + error);
    });
}

function closeChat(chatId) {
    fetch("php/close-chat.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `chat_id=${chatId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Chat has been closed.");
            location.reload(); // Refresh the page to remove closed chats
        } else {
            alert("Error: " + data.error);
        }
    })
    .catch(error => {
        alert("Something went wrong: " + error);
    });
}
</script>

>>>>>>> Stashed changes


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
