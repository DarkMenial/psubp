<?php
session_start();
require_once 'db_connect.php';

// Check if the user is already logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Redirect to the dashboard
    header("location: ../admin/dashboard.php");
    exit;
}

<<<<<<< HEAD
if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] === $username && $row['password'] === $password) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            header("Location: ../../admin/dashboard.php");
            exit();
        }
    }

    // If the execution reaches this point, it means login failed
    $_SESSION['error'] = "Incorrect Username or Password";
    header("Location: ../../admin/login.php");
    exit();
=======
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the entered username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL query to fetch the user record
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the user record from the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // User record found, check if the password matches
            if (password_verify($password, $user['password'])) {
                // Password is correct
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;

                // Redirect to the dashboard
                header("location: ../admin/dashboard.php");
                exit;
            } else {
                // Invalid password
                $error_message = "Wrong password.";
            }
        } else {
            // User record not found
            $error_message = "Username not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the PDO connection
    $pdo = null;
>>>>>>> origin/main
}
?>