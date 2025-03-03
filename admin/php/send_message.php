<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chat_id = $_POST['chat_id'] ?? null;
    $message = $_POST['message'] ?? null;
    $sender_type = $_POST['sender_type'] ?? null;

    if (!$chat_id || !$message || !$sender_type) {
        die("Invalid request");
    }

    // Check if the sender is an admin or user
    $sender_id = $_SESSION['id']; // Get the logged-in user/admin ID
    $user_sender_id = ($sender_type == 'user') ? $sender_id : NULL;
    $admin_sender_id = ($sender_type == 'admin') ? $sender_id : NULL;

    // Insert message into database
    $sqlInsert = $conn->prepare("INSERT INTO chat_messages (chat_room_id, sender_type, user_sender_id, admin_sender_id, message) 
                                VALUES (?, ?, ?, ?, ?)");
    $sqlInsert->bind_param("ssiis", $chat_id, $sender_type, $user_sender_id, $admin_sender_id, $message);

    if ($sqlInsert->execute()) {
        header("Location: ../chat.php?chat_id=$chat_id");
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }

    $sqlInsert->close();
}

$conn->close();
?>


<script>
    function sendMessage(senderType, userId = null, adminId = null) {
  const message = document.getElementById("chat-message").value;
  if (message.trim() !== "") {
    fetch('send_message.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        user_name: window.chatDetails?.name, 
        user_email: window.chatDetails?.email, 
        department: window.chatDetails?.department,
        sender_type: senderType,
        user_id: userId,  // Only for users
        admin_id: adminId, // Only for admins
        message: message 
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        console.log("Message sent!");
      } else {
        alert("Error sending message.");
      }
    })
    .catch(error => console.error("Error:", error));
  }
}

</script>