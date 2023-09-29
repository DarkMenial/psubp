<?php
require_once './db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $new_id = $_POST['account_id'];

    // Update the account in the database
    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, account_id = ? WHERE id = ?");
    $stmt->bind_param('ssii', $username, $password, $new_id, $id);
    $stmt->execute();
    $stmt->close();
    

    // Redirect to the account list page or display a success message
    header("Location: ../manage_users.php"); // Replace "manage_accounts.php" with the appropriate page
    exit();
} else {
    // If the form is not submitted via POST, redirect to the appropriate page
    header("Location: login.php"); // Replace "login.php" with the appropriate page
    exit();
}
?>
