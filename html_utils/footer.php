<<<<<<< Updated upstream
<?php include($_SERVER['DOCUMENT_ROOT'] . '/psubp/html_utils/contact_us.php');?>


    <!-- Your existing footer -->
    <footer class="footer">
      <div class="container">
        <p>&copy; 2023  PSU Brooke's Point. All Rights Reserved.</p>
=======
<?php
// Include necessary PHP files for database connections or other logic
include($_SERVER['DOCUMENT_ROOT'] . '/psubp/html_utils/contact_us.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PSU Brooke's Point</title>
  <!-- Add your stylesheets here -->
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <main>
    <!-- Your existing content goes here -->

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <p>&copy; 2023 PSU Brooke's Point. All Rights Reserved.</p>
>>>>>>> Stashed changes
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
      </div>
    </footer>
  </main>

<<<<<<< Updated upstream
  <script type="module" src="../../.../../../psubp/src/nav.js"></script>
<script type="module" src="../../../src/carousel.js" defer></script>
<script type="module" src="../../../src/script.js" defer></script>
<script type="module" src="../../../src/card-toggle.js"></script>
<script type="module" src="../../../src/grid&list.js"></script>

<script type="module" src="../../../src/main.js" defer></script>
<script type="module" src="../../../src/post-quill.js" defer></script>
<script type="module" src="../../../src/card-toggle.js"></script>
<script type="module" src="../../../src/grid&list.js"></script>

  </body>
</html>

<!-- Floating Chat Icon -->
<div id="chat-icon" onclick="openChatModal()">
  💬
</div>

<!-- Chat Modal -->
<div id="chat-modal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeChatModal()">&times;</span>
    <h2>Start a Chat</h2>
    <form id="chat-form" onsubmit="startChat(event)">
      <label for="user-name">Your Name:</label>
      <input type="text" id="user-name" name="user_name" required>
      
      <label for="user-email">Your Email:</label>
      <input type="email" id="user-email" name="user_email" required>
      
      <label for="department">Choose a Department:</label>
      <select id="department" name="department" required>
        <option value="1">Admissions</option>
        <option value="2">Finance</option>
        <option value="3">IT Support</option>
      </select>
      
      <button type="submit">Start Chat</button>
    </form>
  </div>
</div>


<script>
// Open Modal
function openChatModal() {
  document.getElementById("chat-modal").style.display = "block";
}

// Close Modal
function closeChatModal() {
  document.getElementById("chat-modal").style.display = "none";
}

// Handle Form Submission
function startChat(event) {
  event.preventDefault(); // Prevent form from refreshing the page

  const name = document.getElementById("user-name").value;
  const email = document.getElementById("user-email").value;
  const department = document.getElementById("department").value;

  // You can send an AJAX request here to save the data and initiate the chat
  fetch('start_chat.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ user_name: name, user_email: email, department: department })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Redirect to chat room
      window.location.href = `chat.php?chat_id=${data.chat_id}`;
    } else {
      alert("Failed to start the chat. Please try again.");
    }
  })
  .catch(error => console.error('Error:', error));
}
</script>
=======


  <!-- Include any other scripts -->
  <script type="module" src="../../.../../../psubp/src/nav.js"></script>
  <script type="module" src="../../../src/carousel.js" defer></script>
  <script type="module" src="../../../src/script.js" defer></script>
  <script type="module" src="../../../src/card-toggle.js"></script>
  <script type="module" src="../../../src/grid&list.js"></script>
  <script type="module" src="../../../src/main.js" defer></script>
  <script type="module" src="../../../src/post-quill.js" defer></script>
</body>
</html>

<?php
// Include necessary PHP files for database connections or other logic
include($_SERVER['DOCUMENT_ROOT'] . '/psubp/html_utils/chat_system.php');
?>
>>>>>>> Stashed changes
