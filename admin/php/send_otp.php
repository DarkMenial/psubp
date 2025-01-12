<?php
session_start();
require_once 'db_connect.php';

// Function to generate a 6-digit OTP
function generateOtp() {
    return rand(100000, 999999);
}

// Validate user session
if (!isset($_SESSION['id'])) {
    echo "User not logged in. Cannot generate OTP.";
    exit;
}

// Retrieve the user ID from the session
$userId = intval($_SESSION['id']); // Sanitize user ID

// Fetch user's email from the profiles table
$emailQuery = "
    SELECT p.email 
    FROM users u 
    INNER JOIN profiles p ON u.profile_id = p.id 
    WHERE u.id = ?";
$emailStmt = $conn->prepare($emailQuery);

if ($emailStmt) {
    $emailStmt->bind_param("i", $userId);
    $emailStmt->execute();
    $emailResult = $emailStmt->get_result();
    
    if ($emailResult->num_rows > 0) {
        $userEmail = $emailResult->fetch_assoc()['email'];
    } else {
        echo "Failed to retrieve user email.";
        exit;
    }
    $emailStmt->close();
} else {
    echo "Failed to prepare the email query: " . $conn->error;
    exit;
}

// Delete any previous OTP for this user
$deleteQuery = "DELETE FROM otp_codes WHERE user_id = ?";
$deleteStmt = $conn->prepare($deleteQuery);
if ($deleteStmt) {
    $deleteStmt->bind_param("i", $userId);
    if ($deleteStmt->execute()) {
        echo "Previous OTP deleted successfully.<br>";
    } else {
        echo "Failed to delete previous OTP: " . $deleteStmt->error;
    }
    $deleteStmt->close();
} else {
    echo "Failed to prepare the delete query: " . $conn->error;
    exit;
}

// Generate OTP and set expiration time
$otpCode = generateOtp();
date_default_timezone_set('Asia/Manila'); // Adjust as per your region
$expiration = date('Y-m-d H:i:s', time() + 300); // 5-minute expiration
echo "PHP Expiration Time: $expiration<br>";

// Store OTP and expiration in the session
$_SESSION['otp_code'] = $otpCode;
$_SESSION['otp_expiration'] = $expiration;

// Send the OTP via email
$to = $userEmail; // Use the dynamically retrieved email
$subject = "Your OTP Code"; // Subject line
$message = "Your OTP code is: $otpCode. It is valid for 5 minutes."; // Email message
$headers = "From: moralized19@gmail.com"; // Sender's email address

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully to $to!";
} else {
    echo "Failed to send email.";
    exit; // Stop further processing if email fails
}

// Insert OTP into the database
$query = "INSERT INTO otp_codes (user_id, otp_code, expires_at, is_verified) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
if ($stmt) {
    $is_verified = 0; // Default value for is_verified
    $stmt->bind_param("isss", $userId, $otpCode, $expiration, $is_verified);

    if ($stmt->execute()) {
        echo "OTP stored successfully!";
    } else {
        echo "Failed to store OTP: " . $stmt->error;
        exit;
    }

    $stmt->close();
} else {
    echo "Failed to prepare the query: " . $conn->error;
    exit;
}

// Set session variable for user verification
$_SESSION['user_verified'] = true;

// Redirect to OTP verification page
header("Location: ../login.php");
exit;
?>


