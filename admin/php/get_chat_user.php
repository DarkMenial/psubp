<?php
include('db_connect.php'); 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Set response type to JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $department = mysqli_real_escape_string($conn, $_POST['department']); 
    $created_at = date('Y-m-d H:i:s');

    // Step 1: Check if user already exists
    $user_check_query = "SELECT id FROM chat_users WHERE email = '$user_email' LIMIT 1";
    $user_check_result = mysqli_query($conn, $user_check_query);
    
    if (mysqli_num_rows($user_check_result) > 0) {
        $chat_user = mysqli_fetch_assoc($user_check_result);
        $chat_user_id = $chat_user['id'];
    } else {
        // Insert new user
        $chat_user_query = "INSERT INTO chat_users (name, email, created_at) VALUES ('$user_name', '$user_email', '$created_at')";
        if (mysqli_query($conn, $chat_user_query)) {
            $chat_user_id = mysqli_insert_id($conn);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error creating chat user: ' . mysqli_error($conn)]);
            exit();
        }
    }

    // Step 2: Get account_id based on department
    $account_query = "SELECT account_id FROM accounts WHERE account_name = '$department' LIMIT 1";
    $account_result = mysqli_query($conn, $account_query);
    
    if (mysqli_num_rows($account_result) > 0) {
        $account_data = mysqli_fetch_assoc($account_result);
        $account_id = $account_data['account_id'];

        // Step 3: Check if chat room already exists
        $chat_room_check = "SELECT id FROM chat_rooms WHERE chat_user_id = '$chat_user_id' AND account_id = '$account_id' AND status = 'open' LIMIT 1";
        $chat_room_result = mysqli_query($conn, $chat_room_check);

        if (mysqli_num_rows($chat_room_result) > 0) {
            $chat_room = mysqli_fetch_assoc($chat_room_result);
            $chat_id = $chat_room['id'];
        } else {
            // Create a new chat room
            $chat_room_query = "INSERT INTO chat_rooms (account_id, chat_user_id, status, created_at, updated_at) 
                                VALUES ('$account_id', '$chat_user_id', 'open', '$created_at', '$created_at')";
            if (mysqli_query($conn, $chat_room_query)) {
                $chat_id = mysqli_insert_id($conn);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error creating chat room: ' . mysqli_error($conn)]);
                exit();
            }
        }

        // Store session data
        $_SESSION['chat_user'] = [
            'user_id' => $chat_user_id,
            'user_name' => $user_name,
            'user_email' => $user_email
        ];

        // Send JSON response instead of redirecting
        echo json_encode([
            'status' => 'success',
            'chat_id' => $chat_id,
            'user_name' => $user_name,
            'user_email' => $user_email
        ]);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid department selected.']);
        exit();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>

