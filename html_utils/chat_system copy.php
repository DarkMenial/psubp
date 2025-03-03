<!-- Floating Chat Icon -->
  <div id="chat-icon" onclick="openChatFormModal()">
    💬
  </div>
</div>

<!-- Chat Form Modal -->
<div id="chat-form-modal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeChatFormModal()">&times;</span>
      <h2>Start a Chat</h2>
      <form id="chat-form" action="./admin/php/get_chat_user.php" method="POST">
      <label for="user-name">Your Name:</label>
      <input type="text" id="user-name" name="user_name" required>
      
      <label for="user-email">Your Email:</label>
      <input type="email" id="user-email" name="user_email" required>
      
      <label for="department">Choose a Department:</label>
      <select id="department" name="department" required>
      <?php
            // Fetch departments from the database
            $topicsQuery = "SELECT * FROM accounts";
            $topicsResult = mysqli_query($conn, $topicsQuery);

            while ($row = mysqli_fetch_assoc($topicsResult)) {
              $topicID = $row['account_id'];
              $topicName = $row['account_name'];

              // Populate the dropdown with department names
              echo '<option value="' . htmlspecialchars($topicName, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($topicName, ENT_QUOTES, 'UTF-8') . '</option>';
            }

            mysqli_free_result($topicsResult);
            ?>
      </select>
        <button type="submit">Start Chat</button>
      </form>
    </div>
  </div>

<!-- Chat Room Modal (Initially Hidden) -->
<div id="chat-room-modal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeChatRoomModal()">&times;</span>
    <h3>Chat with <span id="chat-department"></span></h3>
    <iframe id="chat-frame" src="" style="width: 100%; height: 400px; border: none;"></iframe>
  </div>
</div>


  <!-- Scripts -->
  <script>
    // Open Chat Form Modal
    function openChatFormModal() {
  console.log("Modal opening..."); // Check if this logs to the console
  document.getElementById("chat-form-modal").style.display = "block";
}


    // Close Chat Form Modal
    function closeChatFormModal() {
      document.getElementById("chat-form-modal").style.display = "none";
    }

// Open Chat Room Modal
function openChatRoomModal(chatId) {
  const chatFrame = document.getElementById("chat-frame");
  chatFrame.src = `./chat.php?chat_id=${chatId}`; // Load chat.php dynamically
  document.getElementById("chat-room-modal").style.display = "flex";
}


    // Close Chat Room Modal
    function closeChatRoomModal() {
      document.getElementById("chat-room-modal").style.display = "none";
    }

    function startChat(event) {
  event.preventDefault(); // Prevent form submission from refreshing page
  
  // Get user data
  const name = document.getElementById("user-name").value;
  const email = document.getElementById("user-email").value;
  const department = document.getElementById("department").value;

  // Generate a random chat ID (Replace this with real ID from the server)
  const chatId = Math.floor(Math.random() * 10000); // Simulated chat ID
  
  // Store chat details globally
  window.chatDetails = { name, email, department, chatId };
  
  // Set department name in modal
  document.getElementById("chat-department").innerText = department;

  // Close the form modal and open the chat room modal
  closeChatFormModal();
  openChatRoomModal(chatId);
}


    // Send message via AJAX (or use socket for real-time)
    function sendMessage() {
      const message = document.getElementById("chat-message").value;
      if (message.trim() !== "") {
        const messagesDiv = document.getElementById("messages");
        const newMessage = document.createElement("p");
        newMessage.innerText = window.chatDetails.name + ": " + message;
        messagesDiv.appendChild(newMessage);
        document.getElementById("chat-message").value = ""; // Clear the message field

        // Here you can send the message to the server (AJAX or WebSocket)
        fetch('send_message.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ 
            user_name: window.chatDetails.name, 
            user_email: window.chatDetails.email, 
            department: window.chatDetails.department,
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





