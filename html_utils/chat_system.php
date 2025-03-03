


<div id="chat-modal">
    <div id="floating-chat-button" class="floating-chat-button" onclick="toggleChat()">
        <?php if ($chat_active): ?>
            💬  <!-- (Chat Active) -->
        <?php else: ?>
            💬 <!-- (Start New Chat) -->
        <?php endif; ?>
    </div>

    <div class="chat-container">
        <div id="chat-header" class="hidden">
        <?php if ($chat_active): ?>
            <button onclick="goBack()">⬅ Back</button>
        <?php endif; ?>
            <span id="chat-department"><?php echo htmlspecialchars($chat_department); ?></span>
            <button onclick="closeChat()">❌</button>
        </div>

        <div id="chat-sessions" class=" hidden">
            <h3>Your Chat Sessions</h3>
            <ul>
                <?php foreach ($chat_sessions as $session): ?>
                    <li>
                        <button onclick="switchChat('<?php echo $session['chat_id']; ?>', '<?php echo htmlspecialchars($session['account_name']); ?>')">
                        Chat with <?php echo htmlspecialchars($session['account_name'] ?? 'Unknown Department'); ?>
                        </button>
                    </li>
                    
                <?php endforeach; ?>
            </ul>
            <button onclick="showNewChatForm()">+ Start New Chat</button>
        </div>

        <?php if (!$chat_active): ?>
            <!-- Chat form for fresh sessions -->
            <div id="chat-form" class=" chat-form hidden">
                <h3>Start a Chat</h3>
                <form method="POST">
    <label for="name">Your Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required>

    <label for="email">Your Email</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required>

    <label for="account_id">Select Department</label>
    <select id="account_id" name="account_id" required>
        <option value="" disabled selected>Select Department</option>
        <?php foreach ($available_departments as $dept): ?>
            <option value="<?= htmlspecialchars($dept['account_id']); ?>">
                <?= htmlspecialchars($dept['account_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="subject_id">Select Subject</label>
    <select id="subject_id" name="subject_id" required onchange="toggleOtherSubject(this)">
        <option value="" disabled selected>Select a Subject</option>
        <?php foreach ($chat_subjects as $subject): ?>
            <option value="<?= htmlspecialchars($subject['id']); ?>">
                <?= htmlspecialchars($subject['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="text" id="other_subject" name="other_subject" placeholder="Enter subject" style="display: none;">

    <button type="submit">Start Chat</button>
</form>
            </div>
        <?php else: ?>
            <!-- New chat form (only department is selected here) -->
            <div id="new-chat-form" class="chat-form hidden">
                <h3>Start a New Chat</h3>
                <form method="POST">
                  <input type="hidden" name="name" value="<?= htmlspecialchars($user_name); ?>">
                  <input type="hidden" name="email" value="<?= htmlspecialchars($user_email); ?>">

                  <label for="account_id">Select Department</label>
                  <select id="account_id" name="account_id" required>
                      <option value="" disabled selected>Select Department</option>
                      <?php foreach ($available_departments as $dept): ?>
                          <option value="<?= htmlspecialchars($dept['account_id']); ?>">
                              <?= htmlspecialchars($dept['account_name']); ?>
                          </option>
                      <?php endforeach; ?>
                  </select>

                  <label for="subject_id">Select Subject</label>
                  <select id="subject_id" name="subject_id" required onchange="toggleOtherSubject(this)">
                      <option value="" disabled selected>Select a Subject</option>
                      <?php foreach ($chat_subjects as $subject): ?>
                          <option value="<?= htmlspecialchars($subject['id']); ?>">
                              <?= htmlspecialchars($subject['name']); ?>
                          </option>
                      <?php endforeach; ?>
                  </select>

                  <input type="text" id="other_subject" name="other_subject" placeholder="Enter subject" style="display: none;">

                  <button type="submit">Start Chat</button>
                </form>
            </div>
        <?php endif; ?>
        
        <div id="chat-window" class="chat-window hidden">
    <div class="chat-box"></div>

    <!-- Predefined Questions -->
    <div class="bot-questions">
    <button onclick="sendBotMessage('What are the admission requirements?')">Admission Requirements</button>
    <button onclick="sendBotMessage('How do I reset my password?')">Reset Password</button>
    <button onclick="sendBotMessage('Where can I get my student ID?')">Student ID</button>
    <button onclick="sendBotMessage('I need to talk to a person.')">Request a Staff</button>
    </div>


    <div class="typing-area">
        <input type="text" id="user-message" placeholder="Type your message...">
        <button onclick="sendUserMessage()">➤</button>
    </div>
</div>

    </div>
</div>




<script>
function toggleChat() {
    if (<?php echo $chat_active ? 'true' : 'false'; ?>) {
        // If chat is active, show the chat window
        document.getElementById("chat-header").classList.remove("hidden");
        document.getElementById("chat-window").classList.remove("hidden");
    } else {
        // If no active session, show the new chat form
        document.getElementById("chat-form").classList.remove("hidden");
        document.getElementById("chat-header").classList.remove("hidden");
    }
    document.getElementById("floating-chat-button").classList.add("hidden");
}

function goBack() {
    document.getElementById("chat-window").classList.add("hidden");
    document.getElementById("chat-sessions").classList.remove("hidden");
}

function showNewChatForm() {
    document.getElementById("new-chat-form").classList.remove("hidden");
    document.getElementById("chat-sessions").classList.add("hidden");
}

function switchChat(chatId, department) {
    fetch("./admin/php/switch-chat.php?chat_id=" + chatId)
    .then(() => {
        loadMessages();
        document.getElementById("chat-department").innerText = department;
        document.getElementById("chat-sessions").classList.add("hidden");
        document.getElementById("chat-window").classList.remove("hidden");

    });
}

function closeChat() {
    if (<?php echo $chat_active ? 'true' : 'false'; ?>) {
        // If chat is active, show the chat window
    document.getElementById("floating-chat-button").classList.remove("hidden");
    document.getElementById("chat-header").classList.add("hidden");
    document.getElementById("chat-window").classList.add("hidden");
    document.getElementById("chat-sessions").classList.add("hidden");
    document.getElementById("new-chat-form").classList.add("hidden");
    document.getElementById("chat-form").classList.add("hidden");
    } else {
        // If no active session, show the new chat form
        document.getElementById("chat-form").classList.add("hidden");
        document.getElementById("chat-header").classList.add("hidden");
    }
    document.getElementById("floating-chat-button").classList.remove("hidden");
}


function toggleOtherSubject(select) {
        const otherSubjectInput = document.getElementById("other_subject");
        if (select.value === "999") {
            otherSubjectInput.style.display = "block";
            otherSubjectInput.setAttribute("required", "required");
        } else {
            otherSubjectInput.style.display = "none";
            otherSubjectInput.removeAttribute("required");
        }
    }

    function sendMessage(senderType) {
    let message = document.getElementById("user-message").value.trim();
    if (!message) return;

    let data = new URLSearchParams();
    data.append("message", message);
    data.append("sender", senderType); // Dynamically set sender

    fetch("./admin/php/insert-chat.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: data.toString()
    }).then(() => {
        document.getElementById("user-message").value = "";
        loadMessages();
    });
}


function sendUserMessage() {
    sendMessage("User");
}







// Send predefined chatbot questions
function sendBotMessage(question) {
    fetch("./admin/php/insert-chat.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `message=${encodeURIComponent(question)}`
    }).then(() => {
        loadMessages();
    });
}

function loadMessages() {
    fetch("./admin/php/get-chat.php") 
        .then(response => response.text())
        .then(data => {
            document.querySelector(".chat-box").innerHTML = data;
            setTimeout(loadMessages, 2000); // Fetch messages again after 2 seconds
        })
        .catch(error => console.error("Error loading messages:", error));
}

// Start loading messages
loadMessages();



</script>

<style>
    .hidden {
  display: none !important;
}


/* Floating Chat Button */
.floating-chat-button {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #f05c26;
  color: white;
  border: none;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  font-size: 24px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  transition: background 0.3s ease, transform 0.2s ease;
}

.floating-chat-button:hover {
  background-color: #d04d1f;
  transform: scale(1.1);
}

.chat-container {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 350px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}



/* Chat Box */
.chat-box {
  height: 300px;
  overflow-y: auto;
  padding: 12px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

/* Message Structure */
.chat {
  display: flex;
  align-items: flex-end;
  margin-bottom: 10px;
  max-width: 75%;
}

.message-content {
  padding: 10px 14px;
  border-radius: 8px;
  word-wrap: break-word;
  font-size: 14px;
  position: relative;
}


/* Outgoing (User) Message */
.outgoing {
    align-self: flex-end;
    background: #f05c26;
    color: white;
    border-radius: 12px 12px 0px 12px;
}


/* Incoming (Staff) Message */
.incoming, .staff-message {
    align-self: flex-start;
    background: linear-gradient(135deg, #f0f0f0, #d8d5d2);
    color: #333;
    border-radius: 12px 12px 12px 0px;
}

/* Sender Name */
.chat-sender {
  font-size: 12px;
  font-weight: bold;
  display: block;
  margin-bottom: 4px;
}

/* Timestamp */
.timestamp {
  font-size: 10px;
  color: #777;
  position: absolute;
  bottom: -14px;
  right: 8px;
}

/* Input Area */
.typing-area {
  display: flex;
  padding: 8px;
  background: white;
  border-top: 1px solid #ddd;
}

.typing-area input {
  flex: 1;
  padding: 8px;
  border: none;
  outline: none;
  font-size: 14px;
}

.typing-area button {
  background: #f05c26;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  transition: background 0.2s;
}

.typing-area button:hover {
  background: #d04d1f;
}

/* Responsive */
@media screen and (max-width: 400px) {
  .chat-container {
      width: 90%;
      right: 5%;
  }
}


@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Chat Header */
#chat-header {
  background: #f05c26;
  color: white;
  padding: 14px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 16px;
  font-weight: bold;
}

#chat-header button {
  background: transparent;
  border: none;
  color: white;
  font-size: 18px;
  cursor: pointer;
  transition: opacity 0.2s;
}

#chat-header button:hover {
  opacity: 0.8;
}

/* Chat Window */
.chat-window {
  height: auto;
  min-height: 450px;
  overflow-y: auto;
  padding: 12px;
  background: #f9f9f9;
}



/* Chat Messages */
.chat-box {
  height: 240px;
  overflow-y: auto;
  padding: 12px;
  background: #f9f9f9;
  border-bottom: 1px solid #ddd;
  display: flex;
  flex-direction: column;
  gap: 8px;
  scrollbar-width: thin;

}

.chat-box .message {
  padding: 10px 14px;
  border-radius: 8px;
  max-width: 80%;
}

.chat-box .user-message {
  background: #f05c26;
  color: white;
  align-self: flex-end;
}

/* Bot Message Styling */ 
.chat-box .bot-message {
    background: #fce2d5;
    border-radius: 14px 14px 14px 0px;
    align-self: flex-start;
    position: relative;
}

/* Bot Message Icon */
.bot-message::before {
    content: "🤖";
    font-size: 20px;
    position: absolute;
    top: -10px;
    left: 10px;
}

/* Bot Typing Effect */
.bot-message.typing {
    display: inline-block;
    background: linear-gradient(135deg, #444, #666);
    color: #ddd;
}


.bot-questions button {
  background: #f05c26;
  color: white;
  border: none;
  padding: 8px 14px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s ease, transform 0.2s ease;
}

.bot-questions button:hover {
  background: #d04d1f;
  transform: scale(1.05);
}

/* Typing Area */
.typing-area {
  display: flex;
  padding: 8px;
  background: white;
  border-top: 1px solid #ddd;
}

.typing-area input {
  flex: 1;
  padding: 8px;
  border: none;
  outline: none;
  font-size: 14px;
}

.typing-area button {
  background: #f05c26;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  transition: background 0.2s;
}

.typing-area button:hover {
  background: #d04d1f;
}

/* Chat Sessions List */
#chat-sessions ul {
  list-style: none;
  padding: 0;
}

#chat-sessions ul li {
  padding: 10px;
  background: #f5f5f5;
  margin-bottom: 5px;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.2s ease;
}

#chat-sessions ul li:hover {
  background: #e5e5e5;
}

/* Responsive Design */
@media screen and (max-width: 400px) {
  .chat-container {
      width: 90%;
      right: 5%;
  }
  
  .floating-chat-button {
      bottom: 15px;
      right: 15px;
  }
}
</style>

