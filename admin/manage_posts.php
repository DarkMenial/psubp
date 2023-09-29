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
  <!-- <div class="box"> -->
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
            <label for="filter-author">Account:</label>
            <select id="filter-author" name="filter-author">
              <option value="all">All</option>
              <?php
              $authorsQuery = "SELECT DISTINCT account_name FROM accounts";
              $authorsResult = mysqli_query($conn, $authorsQuery);

              while ($username = mysqli_fetch_assoc($authorsResult)) {
                $authorName = $username['account_name'];
                $formattedAuthorName = strtoupper(str_replace('_', ' ', $authorName));
                echo '<option value="' . $authorName . '">' . $formattedAuthorName . '</option>';
              }
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

                echo '<option value="' . $topicID . '">' . $topicName . '</option>';
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
  </div>
  </div>

  <script type="module" src="../src/dropdown.js"></script>
  <script type="module" src="../src/manage-posts.js"></script>
  <script type="module" src="../src/sidebar-toggle.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var filterAccountSelect = document.getElementById("filter-account");
      var loggedInAccountName = "<?php echo $loggedInAccountName; ?>";

      if (loggedInAccountName !== "PSUBP") {
        filterAccountSelect.value = "<?php echo $loggedInAccountID; ?>";
        filterAccountSelect.disabled = true;
      }
    });
  </script>

<script type="module">
  // Get references to the search input and results container
  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');

  // Function to fetch and display the search results
  const fetchSearchResults = async (searchQuery) => {
    try {
      // Send an AJAX request to the server to fetch matching post titles
      const response = await fetch(`search_posts.php?title=${encodeURIComponent(searchQuery)}`);
      const data = await response.json();

      // Clear the previous search results
      searchResults.innerHTML = '';

      // Display the matching post titles
      data.forEach((post) => {
        const postElement = document.createElement('p');
        postElement.textContent = post.title;
        searchResults.appendChild(postElement);
      });
    } catch (error) {
      console.error('Error occurred during search:', error);
    }
  };

  // Add an event listener to the search input to trigger the search
  searchInput.addEventListener('input', () => {
    const searchQuery = searchInput.value.trim(); // Get the search query

    // Perform the search only if the query is not empty
    if (searchQuery.length > 0) {
      fetchSearchResults(searchQuery);
    } else {
      // Clear the search results if the query is empty
      searchResults.innerHTML = '';
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