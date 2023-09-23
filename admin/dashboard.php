<?php
require_once './php/db_connect.php';

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
  // Check if the sidebar state is stored in the session
  if (!isset($_SESSION['sidebarCollapsed'])) {
    // Set the initial state of the sidebar
    $_SESSION['sidebarCollapsed'] = false;
  }

  // Handle the sidebar toggle action
  if (isset($_GET['toggle'])) {
    // Toggle the sidebar state
    $_SESSION['sidebarCollapsed'] = !$_SESSION['sidebarCollapsed'];
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
  }
?>

<?php
include './admin_utils/admin_header.php';
?>

<main class="page-wrapper">
  <div class="box">
    <div class="lg-box">

      <!-- Content of the dashboard goes here -->
      <h1>Manage Post</h1>
      <div class="manage-posts">
        <div class="featured-posts">
          <h3>Featured Posts</h3>

          <button class="change-featured">Change</button>
          <div class="feature-post-options hidden">
            <form id="featurePostForm" method="POST" action="update_featured_post.php">
              <input type="text" name="title" placeholder="Enter Post Title" class="search-feature-post" />

              <select name="type" class="change-featured-dropdown">
                <option value="main">Main Featured</option>
                <option value="sub1">Sub Featured 1</option>
                <option value="sub2">Sub Featured 2</option>
                <option value="sub3">Sub Featured 3</option>
              </select>
              <button type="submit" class="save-button"><i class="fas fa-check"></i>Save</button>
              <button type="button" class="done-button hidden">Done</button>
            </form>
          </div>
        </div>

        <div class="filters">
          <input type="text" placeholder="Search Post..." class="search-post" />

          <div class="filter-container">
            <label for="filter-account">Account:</label>
            <select id="filter-account" name="filter-account">
              <option value="all">All</option> <!-- Add the "All" option -->
              <?php
              $loggedInUserID = $_SESSION['id'];

              // Construct the SQL query to retrieve all account names from the accounts table
              $accountsQuery = "SELECT account_id, account_name FROM accounts";
              $accountsResult = mysqli_query($conn, $accountsQuery);

              while ($account = mysqli_fetch_assoc($accountsResult)) {
                $accountID = $account['account_id'];
                $accountName = $account['account_name'];

                $selected = ($accountID == $filterAccount) ? 'selected' : '';
                echo '<option value="' . $accountID . '"' . $selected . '>' . $accountName . '</option>';
              }

              mysqli_free_result($accountsResult);
              ?>
            </select>
          </div>

          <div class="filter-container">
            <label for="filter-topic">Topic:</label>
            <select id="filter-topic" name="filter-topic">
              <option value="all">All</option>
              <?php
              $topicsQuery = "SELECT * FROM topics";
              $topicsResult = mysqli_query($conn, $topicsQuery);

              while ($row = mysqli_fetch_assoc($topicsResult)) {
                $topicID = $row['topic_id'];
                $topicName = $row['topic_name'];

                echo '<option value="' . $topicName . '">' . $topicName . '</option>';
              }

              mysqli_free_result($topicsResult);
              ?>
            </select>
          </div>
        </div>

        <div class="post-table">
          <table>
            <thead>
              <tr>
                <th>Author</th>
                <th>Title</th>
                <th>Topic</th>
                <th>Date Posted</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php include './php/display_post_table.php'; ?>
            </tbody>
          </table>
        </div>

        <div class="buttons">
          <a href="create_post.php" class="add-post-button"><i class="fas fa-plus"></i>Add Post</a>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded event triggered');
    const filterAccount = document.getElementById('filter-account');
    const filterTopic = document.getElementById('filter-topic');

    filterAccount.addEventListener('change', filterPosts);
    filterTopic.addEventListener('change', filterPosts);

    function filterPosts() {
      const account = filterAccount.value;
      const topic = filterTopic.value;

      const posts = document.querySelectorAll('tr');
      let foundPosts = 0; // Track the number of matching posts

      posts.forEach(function(post) {
        const postAccount = post.getAttribute('data-account');
        const postTopic = post.getAttribute('data-post-type');

        const displayAccount = (account === 'all' || account === postAccount);
        const displayTopic = (topic === 'all' || topic === postTopic);

        if (displayAccount && displayTopic) {
          post.style.display = ''; // Remove the 'display' style to show the row
          foundPosts++; // Increment the count for each matching post
        } else {
          post.style.display = 'none'; // Hide the row
        }
      });

      // Check if no matching posts were found
      const noPostsFoundMessage = document.getElementById('no-posts-found');
      if (foundPosts === 0) {
        noPostsFoundMessage.style.display = ''; // Remove the 'display' style to show the message
      } else {
        noPostsFoundMessage.style.display = 'none'; // Hide the message
      }
    }
  });
</script>

</body>
</html>

<?php
} else {
  header("Location: login.php");
  exit();
}
?>
