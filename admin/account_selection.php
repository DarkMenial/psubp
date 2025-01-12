<?php
session_start();
require_once 'php/db_connect.php';

// Check if the user is already logged in
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  // Redirect the user to the dashboard.php page
  header("Location: dashboard.php");
  exit;
}
$error_message = "";
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/login.css"/>
  <link rel="stylesheet" href="../styles/manage-post.css"/>
  <link rel="stylesheet" href="../styles/modern-normalize.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <title>Account Selection</title>
  <style>
    .custom-container {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .choose-account {
      margin-top: 20px;
      text-align: center;
    }
    .account-options {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }
    .account-option {
      background-color: #fff;
      border-radius: 10px;
      width: 200px;
      height: 120px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 10px;
    }
    .account-option:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }    
    .account-img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      overflow: hidden;
      margin-bottom: 10px;
    }
    .account-name {
      font-size: 16px;
      font-weight: bold;
      color: #333;
      text-align: center;
      margin-top: 5px;
    }
    .title {
      font-size: 24px;
      margin-bottom: 20px;
    }
    .flash-message {
      color: #ff6347;
      font-size: 14px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="custom-container">
    <h2 class="title">ADMIN DASHBOARD</h2>
    <?php if (!empty($error_message)) { ?>
      <div id="login-message">
        <p class="flash-message error"><?php echo $error_message; ?></p>
      </div>
    <?php } ?>
    <div class="choose-account">
      <h3>Choose Account</h3>
      <div class="account-options">
        <?php
        // Fetch multiple accounts for the logged-in user from the database
        $userId = $_SESSION['id']; // Assuming 'id' is the user ID
        $query = "SELECT DISTINCT a.account_id, a.account_name FROM account_users au JOIN accounts a ON au.account_id = a.account_id WHERE au.user_id = $userId";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $accountId = $row['account_id'];
            $accountName = $row['account_name'];
            echo "<div class='account-option' id='account$accountId' onclick='selectAccount($accountId)'>
                    <div class='account-img'>
                      <!-- You can replace this with the user's profile picture -->
                      <img src='profile_picture.jpg' alt='Profile Picture'>
                    </div>
                    <span class='account-name'>$accountName</span>
                  </div>";
          }
        } else {
          echo "<p>No accounts found.</p>";
        }
        ?>
      </div>
    </div>
  </div>
  
  <script>
    function selectAccount(accountId) {
      // Simulate setting the selected account in the session
      alert("Selected account ID: " + accountId);
      // Redirect to the dashboard or perform other actions as needed
    }
  </script>
</body>
</html>
