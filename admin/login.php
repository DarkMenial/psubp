<?php
session_start();
require_once 'php/db_connect.php';

// Check if logout action is requested
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = array(); // Unset all session variables
    session_destroy(); // Destroy the session
    session_regenerate_id(false); // Prevent session regeneration
    header("Location: login.php");
    exit;
}

// Debugging session variables (for development only, remove in production)
// var_dump($_SESSION);

// Check if the user is fully logged in
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    header("Location: dashboard.php");
    exit;
}

// Initialize error message
$error_message = $_SESSION['error'] ?? '';
unset($_SESSION['error']);


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
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="../public/logo.png" alt="University Logo" />
        </div>
        <h2 class="title">ADMIN DASHBOARD</h2>

        <?php if (!empty($error_message)) { ?>
            <div id="login-message">
                <p class="flash-message error"><?= htmlspecialchars($error_message) ?></p>
            </div>
        <?php } ?>

        <div class="wrapper">
            <!-- Check session states to render the correct form -->
            <?php if (!isset($_SESSION['user_verified'])) { ?>
                <!-- Display Username & Password Form -->
                <form class="form-group" action="./php/admin_login.php" method="POST" id="loginForm">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <div class="password-toggle">
                            <input type="password" id="password" name="password" placeholder="Enter your password" required oninput="handlePasswordInput()">
                            <span class="toggle-icon" id="toggleIcon" onclick="togglePasswordVisibility()" style="display: none;">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="submit-button" type="submit">Sign In</button>
                    </div>
                </form>

            <?php } elseif (isset($_SESSION['user_verified']) && $_SESSION['user_verified'] === true && !isset($_SESSION['otp_verified'])) { ?>
                <!-- Display OTP Form -->
                <div class="otp-container">
                    <form class="form-group" action="./php/verify_otp.php" method="POST" id="otpForm">
                        <div class="form-group">
                            <input type="text" id="otp" name="otp" placeholder="Enter your OTP" required>
                        </div>
                        <div class="form-group">
                            <button class="submit-button" type="submit">Verify OTP</button>
                        </div>
                    </form>
                    <?php if (!empty($otp_message)) { ?>
                        <p class="otp-message"><?= htmlspecialchars($otp_message) ?></p>
                    <?php } ?>
                    <div class="button-row">
                        <span id="resendOtp" onclick="redirectToResendOtp()">Resend OTP</span>
                        <span id="timer">00:30</span>
                    </div>


                </div>
            </div>
            <?php } elseif (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true) { ?>
                <!-- Account Selection Modal -->
                <div id="accountModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h3 style="margin-bottom: 20px;">Choose Account</h3>
                        <div class="account-options">
                            <?php
                            $userId = $_SESSION['id'];
                            $query = "SELECT DISTINCT a.account_id, a.account_name 
                                      FROM account_users au 
                                      JOIN accounts a ON au.account_id = a.account_id 
                                      WHERE au.user_id = $userId";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $accountId = $row['account_id'];
                                    $accountName = $row['account_name'];
                                    echo "<div class='account-option' onclick='completeLogin($accountId)'>
                                            <div class='account-img'>
                                                <img src='../public/logo.png' alt='Profile Picture'>
                                            </div>
                                            <div class='account-name'>$accountName</div>
                                          </div>";
                                }
                            } else {
                                echo "<p>No accounts found.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
let countdownTime = 30; // Countdown in seconds
const resendText = document.getElementById("resendOtp");
const timerDisplay = document.getElementById("timer");

function startCountdown() {
    let timeRemaining = countdownTime;
    timerDisplay.textContent = `00:${timeRemaining < 10 ? '0' : ''}${timeRemaining}`;
    resendText.classList.add("disabled");

    const countdownInterval = setInterval(() => {
        timeRemaining -= 1;
        timerDisplay.textContent = `00:${timeRemaining < 10 ? '0' : ''}${timeRemaining}`;
        
        if (timeRemaining <= 0) {
            clearInterval(countdownInterval);
            resendText.classList.remove("disabled");
            timerDisplay.textContent = "00:00";
        }
    }, 1000);
}

function redirectToResendOtp() {
    window.location.href = "../../psubp/admin/php/send_otp.php";
}


function resendOtp() {
    if (resendText.classList.contains("disabled")) return;

    resendText.classList.add("disabled");
    timerDisplay.textContent = `Sending...`;

    const formData = new FormData();
    formData.append('action', 'resend_otp');

    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then((data) => {
        timerDisplay.textContent = "Resent!";
        startCountdown();
    })
    .catch(() => {
        timerDisplay.textContent = "Failed to resend.";
        resendText.classList.remove("disabled");
    });
}

startCountdown(); // Start the initial countdown when page loads

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon").querySelector("i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }
        }

        function handlePasswordInput() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.value.length > 0) {
                toggleIcon.style.display = "inline";
            } else {
                toggleIcon.style.display = "none";
            }
        }
    </script>
     <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon").querySelector("i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }
        }

        function handlePasswordInput() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            // Show the toggle icon only if there are characters in the password input
            if (passwordInput.value.length > 0) {
                toggleIcon.style.display = "inline";
            } else {
                toggleIcon.style.display = "none";
            }
        }

        function openModal() {
            const modal = document.getElementById("accountModal");
            modal.style.display = "block";
        }

        function closeModal() {
            const modal = document.getElementById("accountModal");
            modal.style.display = "none";
        }

        function completeLogin(accountId) {
            const form = document.createElement("form");
            form.method = "post";
            form.action = "./php/select_account.php";
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "selected_account";
            input.value = accountId;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true) { ?>
                openModal();
            <?php } ?>
        });
    </script>
</body>
</html>
