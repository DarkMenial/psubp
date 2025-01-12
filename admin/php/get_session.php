<?php

require_once 'db_connect.php';

function addSession($userId, $sessionId) {
    global $conn;
    $query = "INSERT INTO active_sessions (user_id, session_id) VALUES ($userId, '$sessionId')";
    mysqli_query($conn, $query);
}

function removeSession($sessionId) {
    global $conn;
    $query = "DELETE FROM active_sessions WHERE session_id = '$sessionId'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Session removed successfully.";
    } else {
        echo "Error removing session: " . mysqli_error($conn);
    }
}



function isSessionActive($sessionId) {
    global $conn;
    $query = "SELECT * FROM active_sessions WHERE session_id = '$sessionId'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}
?>
