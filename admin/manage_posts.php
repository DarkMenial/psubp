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

  // Fetch the selected account ID from the session
  $selectedAccountID = $_SESSION['selected_account'];

  // Fetch the account name based on the selected account ID
  $accountQuery = "SELECT account_name FROM accounts WHERE account_id = $selectedAccountID";
  $accountResult = mysqli_query($conn, $accountQuery);

  if ($accountResult && mysqli_num_rows($accountResult) > 0) {
    $account = mysqli_fetch_assoc($accountResult);
    $loggedInAccountName = $account['account_name'];
  } else {
    $loggedInAccountName = 'No account found';
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

                $selected = ($accountID === $filterAccount) ? 'selected' : '';
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
              $query = "SELECT * FROM topics";
              $result = mysqli_query($conn, $query);

              while ($row = mysqli_fetch_assoc($result)) {
                $topicID = $row['topic_id'];
                $topicName = $row['topic_name'];

                $selected = ($topicID === $filterTopic) ? 'selected' : '';
                echo '<option value="' . $topicID . '"' . $selected . '>' . $topicName . '</option>';
              }

              mysqli_free_result($result);
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
      </div>
    </div>
    </div>

     <!-- Overlay for the floating modal -->
     <div class="modal-overlay" id="modalOverlay"></div>

<!-- Floating modal for the audit trail -->
<div id="auditModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div id="auditTrailContent"></div>
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
              filterAccountSelect.value = "<?php echo $selectedAccountID; ?>";
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

<script>
document.querySelectorAll('.archive-link').forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action (navigating to another page)
        
        // Retrieve the data from the clicked link
        var id = this.getAttribute('data-id');
        
        // Send the data to get_archive.php using a POST request
        fetch('../admin/get_archive.php', {
            method: 'POST',
            body: JSON.stringify({
                type: 'post', // Specify the type (you can change this as needed)
                item: id, // The item ID you want to archive
                account_id: <?php echo $loggedInAccountID; ?>, // Use the appropriate account ID
                table_name: 'posts' // Specify the table name for posts
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response) {
            return response.text();
        }).then(function(data) {
            alert(data); // Display the response
        }).catch(function(error) {
            console.error('Error:', error);
        });
    });
});
</script>

<script>
// JavaScript to handle the modal and fetching audit trail

// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get all the buttons with the class 'view-audit'
    var viewAuditButtons = document.querySelectorAll('.view-audit');
    
    // Add a click event listener to each button
    viewAuditButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Get the post ID associated with the button
            var postId = this.getAttribute('data-post-id');
            
            // Fetch the audit trail for the corresponding post using AJAX
            fetch('php/display_audit_trail.php?post_id=' + postId)
            .then(response => response.text())
            .then(data => {
                // Display the audit trail in a modal or popup
                // You can use Bootstrap Modal or any other popup library here
                // For example:
       
            .catch(error => {
                console.error('Error fetching audit trail:', error);
            });
        });
    });
});
</script>

<!-- JavaScript code to handle modal and fetch audit trail -->
<script>

// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get all the buttons with the class 'view-audit'
    var viewAuditButtons = document.querySelectorAll('.view-audit');
    
    // Add a click event listener to each button
    viewAuditButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Get the post ID associated with the button
            var postId = this.getAttribute('data-post-id');
            
            // Fetch the audit trail for the corresponding post using AJAX
            fetch('php/display_audit_trail.php?post_id=' + postId)
            .then(response => response.text())
            .then(data => {
                // Display the audit trail in the floating modal
                document.getElementById('auditTrailContent').innerHTML = data;
                document.getElementById('auditModal').style.display = "block"; // Show the modal
                document.getElementById('modalOverlay').style.display = "block"; // Show the overlay
            })
            .catch(error => {
                console.error('Error fetching audit trail:', error);
            });
        });
    });

    // Get the <span> element that closes the modal
    var closeBtn = document.querySelector('.modal .close');

    // Add click event listener to close the modal when close button is clicked
    closeBtn.addEventListener('click', function() {
      document.getElementById('auditModal').style.display = "none"; // Hide the modal
      document.getElementById('modalOverlay').style.display = "none"; // Hide the overlay
    });

    // When the user clicks anywhere outside of the modal, close it
    window.addEventListener('click', function(event) {
      var modal = document.getElementById('auditModal');
      var overlay = document.getElementById('modalOverlay');
      if (event.target == overlay) {
        modal.style.display = "none"; // Hide the modal
        overlay.style.display = "none"; // Hide the overlay
      }
    });
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