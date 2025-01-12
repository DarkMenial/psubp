<?php
session_start();
require_once 'db_connect.php';

// Debug: Output session variables to check if they are set correctly
var_dump($_SESSION);

// Check if user is logged in and OTP is set
if (!isset($_SESSION['id']) || !isset($_SESSION['otp_code'])) {
    header("Location: ../../admin/login.php");
    exit();
}

$error_message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['otp'])) {
    $enteredOtp = $_POST['otp'];
    $userId = $_SESSION['id'];

    // Debug: Output entered OTP for verification
    // var_dump($enteredOtp);

    // Retrieve OTP from the database
    $otpQuery = "SELECT otp_code, expires_at 
FROM otp_codes 
WHERE user_id = ? AND is_verified = 0 AND expires_at > NOW() 
ORDER BY expires_at DESC LIMIT 1;";
    $stmt = $conn->prepare($otpQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Debug: Output the fetched OTP
    var_dump($row);

    if ($row && $enteredOtp == $row['otp_code']) {
        // OTP is correct, finalize login
        $_SESSION['otp_verified'] = true;
        unset($_SESSION['otp_code']); // Remove OTP from session

        // Update OTP as verified
        $updateOtpQuery = "UPDATE otp_codes SET is_verified = 1 WHERE user_id = ? AND otp_code = ?";
        $updateStmt = $conn->prepare($updateOtpQuery);
        $updateStmt->bind_param("is", $userId, $enteredOtp);
        $updateStmt->execute();

       // Delete the OTP code from the database after verification
       $deleteOtpQuery = "DELETE FROM otp_codes WHERE user_id = ? AND otp_code = ?";
       $deleteStmt = $conn->prepare($deleteOtpQuery);
       $deleteStmt->bind_param("is", $userId, $enteredOtp);
       $deleteStmt->execute();

        // Check if user has multiple accounts
        $query = "SELECT COUNT(*) AS count FROM account_users WHERE user_id = ?";
        $countStmt = $conn->prepare($query);
        $countStmt->bind_param("i", $userId);
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $accountCount = $countResult->fetch_assoc()['count'];

        if ($accountCount > 1) {
            // Redirect to the login page to show account selection modal
            $_SESSION['otp_verified'] = true;
            header("Location: ../../admin/login.php");
            exit();
        } else {
            // Redirect to the dashboard with the default account
            $accountQuery = "SELECT account_id FROM account_users WHERE user_id = ? LIMIT 1";
            $accountStmt = $conn->prepare($accountQuery);
            $accountStmt->bind_param("i", $userId);
            $accountStmt->execute();
            $accountResult = $accountStmt->get_result();
            $_SESSION['selected_account'] = $accountResult->fetch_assoc()['account_id'];

            // Set the logged in session variable
            $_SESSION['isLoggedIn'] = true;
            header("Location: ../../admin/dashboard.php");
            exit();
        }
    } else {
        // Incorrect OTP
        $_SESSION['error'] = "Invalid OTP or OTP has expired. Please try again.";
        header("Location: ../../admin/login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Unauthorized access.";
    header("Location: ../../admin/login.php");
    exit();
}
?>
