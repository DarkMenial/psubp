<?php
require_once 'db_connect.php';

// Get the logged-in user's ID
$loggedInUserID = $_SESSION['id'];

// Retrieve the selected account ID from the session or URL parameter
$selectedAccountID = isset($_SESSION['selected_account']) ? $_SESSION['selected_account'] : null;




// Function to archive a post and log it in archived_items table
function archivePost($postId, $conn, $loggedInUserID) {
  // Archive the post in 'posts' table
  $archiveQuery = "UPDATE posts SET archived = 1 WHERE id = '$postId'";
  $archiveResult = mysqli_query($conn, $archiveQuery);

  if ($archiveResult) {
      // Log the archived post in archived_items table
      $insertQuery = "INSERT INTO archived_items (item_id, item_type, archived_by)
                      VALUES ('$postId', 'Post', '$loggedInUserID')";
      $insertResult = mysqli_query($conn, $insertQuery);

      if ($insertResult) {
          echo "<script>alert('Post archived successfully.'); window.location.href = 'manage_posts.php';</script>";
      } else {
          echo "<script>alert('Error logging archived post: " . mysqli_error($conn) . "');</script>";
      }
  } else {
      echo "<script>alert('Error archiving post: " . mysqli_error($conn) . "');</script>";
  }
}

// Check if 'archive_id' is set in URL (assuming it's for post)
if (isset($_GET['archive_id'])) {
    $archiveId = $_GET['archive_id'];
    archivePost($archiveId, $conn, $loggedInUserID);
}

// Delete post
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM posts WHERE id = '$deleteId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('Post deleted successfully.'); window.location.href = 'manage_posts.php';</script>";
    } else {
        echo "<script>alert('Error deleting post: " . mysqli_error($conn) . "');</script>";
    }
}

// Publish/Unpublish post
if (isset($_GET['publish_id']) && isset($_GET['publish'])) {
    $publishId = $_GET['publish_id'];
    $publishStatus = $_GET['publish'];
    $publishQuery = "UPDATE posts SET publish = '$publishStatus' WHERE id = '$publishId'";
    $publishResult = mysqli_query($conn, $publishQuery);

    if ($publishResult) {
        echo "<script>window.location.href = 'manage_posts.php';</script>";
    } else {
        echo "<script>alert('Error " . ($publishStatus == 1 ? 'publishing' : 'unpublishing') . " post: " . mysqli_error($conn) . "');</script>";
    }
}

// Construct the SQL query to retrieve the logged-in user's account
$accountQuery = "SELECT au.account_id, a.account_name
                FROM account_users au
                JOIN accounts a ON au.account_id = a.account_id
                WHERE au.user_id = '$loggedInUserID'";

// Add a condition to filter by selected account ID, if available
if ($selectedAccountID) {
    $accountQuery .= " AND au.account_id = '$selectedAccountID'";
}

$accountResult = mysqli_query($conn, $accountQuery);

// Check if the query executed successfully and a row is returned
if ($accountResult && mysqli_num_rows($accountResult) > 0) {
    $account = mysqli_fetch_assoc($accountResult);
    $loggedInAccountID = $account['account_id'];
    $loggedInAccountName = $account['account_name'];

    // Construct the SQL query to retrieve posts
    $query = "SELECT DISTINCT p.id, p.title, t.topic_name, a.account_name, pr.name, p.publish, p.date_posted
              FROM posts p
              JOIN account_users au ON p.account_id = au.account_id
              JOIN users u ON au.user_id = u.id
              JOIN profiles pr ON u.profile_id = pr.id
              JOIN accounts a ON au.account_id = a.account_id
              JOIN topics t ON p.topic_id = t.topic_id";

    // Exclude archived posts from the results
    $query .= " WHERE p.archived = 0";

    // If the logged-in account is not PSUBP, add the account filter condition
    if ($loggedInAccountName !== 'PSUBP') {
        $query .= " AND p.account_id = '$loggedInAccountID'";
    }

    // Execute the SELECT query
    $result = mysqli_query($conn, $query);

    function hasPermission($userID, $permissionName) {
        global $conn;

        $sql = "SELECT p.name AS permission_name 
                FROM users u
                JOIN user_permissions up ON u.id = up.user_id
                JOIN permissions p ON up.permission_id = p.id
                WHERE u.id = '$userID'";

        $result = mysqli_query($conn, $sql);

        $userPermissions = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $userPermissions[] = $row['permission_name'];
            }
        }

        return in_array($permissionName, $userPermissions);
    }

    // Check if the query executed successfully
    if ($result) {
        // Initialize an array to store unique post IDs
        $uniquePostIDs = [];

        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            // Display the posts
            while ($post = mysqli_fetch_assoc($result)) {
                // Check if the post ID is already displayed
                if (!in_array($post['id'], $uniquePostIDs)) {
                    // Add the post ID to the array of unique IDs
                    $uniquePostIDs[] = $post['id'];

                    echo '<tr>';
                    echo '<td>';
                    echo '<span>' . strtoupper($post['account_name']) . '</span><br>';
                    echo '<span style="opacity: 0.9; font-size: 13px;">' . $post['name'] . '</span>';
                    echo '</td>';
                    echo '<td>' . $post['title'] . '</td>';
                    echo '<td>' . $post['topic_name'] . '</td>';
                    echo '<td>' . $post['date_posted'] . '</td>';
                    echo '<td>';

                    $isAdmin = hasPermission($loggedInUserID, 'admin');

                    if ($isAdmin) {
                        // Show all buttons for admin
                        echo '<a href="../admin/edit_post.php?id=' . $post['id'] . '">Edit</a> | ';
                        echo '<a href="?delete_id=' . $post['id'] . '" onclick="return confirm(\'Are you sure you want to delete this post?\')">Delete</a> | ';
                        echo '<a href="?archive_id=' . $post['id'] . '">Archive</a> | ';
                        if ($post['publish'] == 1) {
                            echo '<a href="?publish_id=' . $post['id'] . '&publish=0">Unpublish</a> | ';
                        } else {
                            echo '<a href="?publish_id=' . $post['id'] . '&publish=1">Publish</a> | ';
                        }
                        echo '<button class="btn btn-primary view-audit" data-post-id="' . $post['id'] . '">View Audit</button>';
                    } else {
                        // Check for individual permissions if not admin
                        if (hasPermission($loggedInUserID, 'edit_post')) {
                            echo '<a href="../admin/edit_post.php?id=' . $post['id'] . '">Edit</a> | ';
                        }
                        if (hasPermission($loggedInUserID, 'delete_post')) {
                            echo '<a href="?delete_id=' . $post['id'] . '" onclick="return confirm(\'Are you sure you want to delete this post?\')">Delete</a> | ';
                        }
                        if (hasPermission($loggedInUserID, 'archive_post')) {
                            echo '<a href="?archive_id=' . $post['id'] . '">Archive</a> | ';
                        }
                        if (hasPermission($loggedInUserID, 'publish_post')) {
                            if ($post['publish'] == 1) {
                                echo '<a href="?publish_id=' . $post['id'] . '&publish=0">Unpublish</a> | ';
                            } else {
                                echo '<a href="?publish_id=' . $post['id'] . '&publish=1">Publish</a>';
                            }
                        }
                        echo '<button class="btn btn-primary view-audit" data-post-id="' . $post['id'] . '">View Audit</button>';
                    }

                    echo '</td>';
                    echo '</tr>';
                    
              
                }
            }
        } else {
            // No posts found
            echo '<tr><td colspan="5">No posts found</td></tr>';
        }

        // Free the result set
        mysqli_free_result($result);
    } else {
        // Display the MySQL error
        echo 'Query error: ' . mysqli_error($conn);
    }

    // Free the account result set
    mysqli_free_result($accountResult);
} else {
    // No account found for the logged-in user
    echo 'No account found for the logged-in user.';
}
echo '</tbody>';
echo '</table>';
echo '</div>';
echo '<div class="buttons">';
$isAdmin = hasPermission($loggedInUserID, 'admin');

if ($isAdmin) {
echo '<a href="create_post.php" class="add-post-button"><i class="fas fa-plus"></i>Add Post</a>';
} else {
    // Check for individual permissions if not admin
    if (hasPermission($loggedInUserID, 'create_post')) {
        echo '<a href="create_post.php" class="add-post-button"><i class="fas fa-plus"></i>Add Post</a>';
    }
}
echo '</div>';

// Close MySQL connection
mysqli_close($conn);
?>
