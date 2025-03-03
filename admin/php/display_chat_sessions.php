<?php
require_once 'db_connect.php';


// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Retrieve the selected account ID from the session or URL parameter
$selectedAccountID = isset($_SESSION['selected_account']) ? $_SESSION['selected_account'] : null;

// Construct the SQL query to retrieve the logged-in user's account
$accountQuery = "SELECT au.account_id, a.account_name
                FROM account_users au
                JOIN accounts a ON au.account_id = a.account_id";
$accountResult = mysqli_query($conn, $accountQuery);
// Check if the query executed successfully and a row is returned
if ($accountResult && mysqli_num_rows($accountResult) > 0) {
    $account = mysqli_fetch_assoc($accountResult);
}




// Add a condition to filter by selected account ID, if available
if ($selectedAccountID) {
    $accountQuery .= " AND au.account_id = '$selectedAccountID'";
}


// Get the filter values
$filterPosition = $_GET['filter-position'] ?? 'all';


$subjectQuery = "SELECT cs.*, s.name 
                  FROM chat_sessions cs
                  JOIN chat_subjects s ON cs.subject_id = s.id";
$subjectResult = mysqli_query($conn, $subjectQuery);
// Check if the query executed successfully and a row is returned
if ($subjectResult && mysqli_num_rows($subjectResult) > 0) {
    $subject = mysqli_fetch_assoc($subjectResult);
}


// Construct the SQL query based on the filter values
$chatSessionQuery = "SELECT cs.*, a.account_name, s.name 
                     FROM chat_sessions cs 
                     JOIN accounts a ON cs.account_id = a.account_id 
                     JOIN chat_subjects s ON cs.subject_id = s.id";
$chatSessionResult = mysqli_query($conn, $chatSessionQuery);


// Check if the query executed successfully and a row is returned
if ($chatSessionResult && mysqli_num_rows($chatSessionResult) > 0) {
    $chatSession = mysqli_fetch_assoc($chatSessionResult);
}


    // Execute the SELECT query
    $result = mysqli_query($conn, $chatSessionQuery);

    // Check if the query executed successfully
    if ($result) {

        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            // Display the chatSession logs
            while ($chatSession = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $chatSession['chat_id'] . '</td>'; 
            echo '<td>' . $chatSession['name'] . '</td>';
            echo '<td>' . $chatSession['account_name'] . '</td>';
            echo '<td>' . $chatSession['user_name'] . '</td>';
            echo '<td>' . $chatSession['user_email'] . '</td>';
            echo '<td>' . $chatSession['status'] . '</td>';
            echo '<td>' . $chatSession['last_activity'] . '</td>';
            echo '<td>
            <button onclick="joinChat(\'' . $chatSession['chat_id'] . '\')">Join Chat</button> | 
            <button onclick="closeChat(\'' . $chatSession['chat_id'] . '\')">Close Chat</button>
                  </td>';
            echo '</tr>';
        }
    } 
    else {
        echo '<p>No profiles found.</p>';
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Display the MySQL error
    echo 'Query error: ' . mysqli_error($conn);
}
?>
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
