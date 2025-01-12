<?php
session_start();
require_once 'db_connect.php';
require 'PHPMailerAutoload.php';  // Ensure PHPMailer is included

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Generate a random OTP
    $otp = random_int(100000, 999999);
    $user_email = $_POST['email'];

    // Set OTP expiration (10 minutes)
    $expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    // Assuming you have a user_id from the session or elsewhere
    $user_id = 1; // Replace with your user's ID

    // Store OTP in the database
    $stmt = $db->prepare("INSERT INTO otp_codes (user_id, otp_code, expires_at) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $otp, $expires_at]);

    // Send OTP via email using PHPMailer
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@gmail.com';
    $mail->Password = 'your-password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('your-email@gmail.com', 'Your Website');
    $mail->addAddress($user_email);
    $mail->isHTML(true);

    $mail->Subject = 'Your OTP Code';
    $mail->Body    = "Your OTP code is <b>$otp</b> and it is valid for 10 minutes.";

    if(!$mail->send()) {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'OTP has been sent!';
    }
}
?>
