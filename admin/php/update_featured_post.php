<?php
require_once 'db_connect.php';
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the selected type and title from the form submission
  $title = $_POST['title'];
  $title = trim($title);

  // Validate and sanitize the input
  $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
  $title = filter_var($title, FILTER_SANITIZE_STRING);

  // Prepare the statement to fetch the post ID based on the entered title
  $query = "SELECT id FROM posts WHERE title = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $title);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $postID = $row['id'];

    // Check if the record already exists in featured_posts table
    $existingQuery = "SELECT post_id FROM featured_posts WHERE type = ?";
    $existingStmt = $conn->prepare($existingQuery);
    $existingStmt->bind_param("s", $type);
    $existingStmt->execute();
    $existingResult = $existingStmt->get_result();

    if ($existingResult && $existingResult->num_rows > 0) {
      // Update the existing record
      $updateQuery = "UPDATE featured_posts SET post_id = ? WHERE type = ?";
      $updateStmt = $conn->prepare($updateQuery);
      $updateStmt->bind_param("is", $postID, $type);
      $updateResult = $updateStmt->execute();

      if ($updateResult) {
        // Success
        http_response_code(200);
      } else {
        // Error
        http_response_code(500);
      }
    } else {
      // Insert a new record
      $insertQuery = "INSERT INTO featured_posts (post_id, type) VALUES (?, ?)";
      $insertStmt = $conn->prepare($insertQuery);
      $insertStmt->bind_param("is", $postID, $type);
      $insertResult = $insertStmt->execute();

      if ($insertResult) {
        // Success
        http_response_code(200);
      } else {
        // Error
        http_response_code(500);
      }
    }
  } else {
    // No matching post found
    http_response_code(404);
  }



}
?>