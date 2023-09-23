<?php
session_start();

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
  <title>Admin Login</title>
  <style>
    .password-toggle .toggle-icon {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="../public/logo.png" alt="University Logo" />
    </div>
    <h2 class="title">ADMIN DASHBOARD</h2>
    <?php if (!empty($error_message)) { ?>
      <div id="login-message">
        <p class="flash-message error"><?php echo $error_message; ?></p>
      </div>
    <?php } ?>
    <div class="wrapper">
      <?php if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { ?>
      <form class="form-group" action="./php/admin_login.php" method="POST">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <div class="password-toggle">
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <span class="toggle-icon" onclick="togglePasswordVisibility()"><i class="fas fa-eye"></i></span>
          </div>
        </div>
        <div class="form-group">
          <button class="submit-button" type="submit">Sign In</button>
        </div>
      </form>
      <?php } else { ?>
      <p>You are already logged in. Redirecting to the dashboard...</p>
      <?php header("Refresh: 2; URL=../admin/dashboard.php"); ?>
      <?php } ?>
    </div>
  </div>
  
  <script>
  function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var toggleIcon = document.querySelector(".toggle-icon");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
      passwordInput.type = "password";
      toggleIcon.innerHTML = '<i class="fas fa-eye"></i>';
    }
  }

  var passwordInput = document.getElementById("password");
  var toggleIcon = document.querySelector(".toggle-icon");

  passwordInput.addEventListener("input", function() {
    if (passwordInput.value.length > 0) {
      toggleIcon.style.display = "block";
    } else {
      toggleIcon.style.display = "none";
    }
  });

  // Hide the toggle icon initially
  toggleIcon.style.display = "none";
</script>


</body>
</html>