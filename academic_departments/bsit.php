<?php include '../html_utils/header_department.php';?>

<nav class="second-nav">
  <div class="container">
    <ul class="second-nav-list">
      <li><a href="#">Overview</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">People</a></li>
      <li><a href="#">News & Events</a></li>
      <li><a href="#">Announcements</a></li>
    </ul>
  </div>
</nav>
</header>

<section id="hero-department" class="hero-department">
  <video id="hero-department-video" autoplay muted loop>
    <source src="../public/video.mp4" type="video/mp4">
  </video>
</section>

<div class="section"></div>

<main>
  <section id="news-events">
    <!-- Main Featured Post -->
    <div class="news-events container btn">
      <div class="main-featured">
        <?php include '../admin/php/display_post_main_featured.php'; ?>
      </div>
    </div>
  </section>

  <div class="section"></div>

  <section class="container">
    <div id="items-container" class="container__sidemain">
      <div class="sidebar__sticky">
        <div class="filter-section">
          <div class="display-toggle">
            <div class="toggle-btn active" data-display-type="grid">
              <i class="fas fa-th-large" style="margin-right: 10px;"></i>Grid View
            </div>
            <div class="toggle-btn" data-display-type="list">
              <i class="fas fa-list" style="margin-right: 10px; padding: 0;"></i>List View
            </div>
          </div>
          <label for="filter-author">Author:</label>
          <select id="filter-author" name="filter-author" disabled>
            <?php
            $authorsQuery = "SELECT DISTINCT account_name FROM accounts";
            $authorsResult = mysqli_query($conn, $authorsQuery);

            while ($username = mysqli_fetch_assoc($authorsResult)) {
              $authorName = $username['account_name'];
              $formattedAuthorName = strtoupper(str_replace('_', ' ', $authorName));

              if ($authorName === 'BSIT') {
                echo '<option value="' . $authorName . '" selected>' . $formattedAuthorName . '</option>';
              } else {
                echo '<option value="' . $authorName . '">' . $formattedAuthorName . '</option>';
              }
            }
            ?>
          </select>

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

      <div class="main">
        <p id="no-posts-found" style="display: none;">No posts found.</p>

<?php
$postsQuery = "SELECT * FROM posts WHERE account_name = 'BSIT'";
$postsResult = mysqli_query($conn, $postsQuery);

if (mysqli_num_rows($postsResult) > 0) {
  while ($row = mysqli_fetch_assoc($postsResult)) {
    // Display the posts from the "BSIT" account
    // Modify the code here to display the posts as desired
    echo '<div class="card" data-author="' . $row['account_name'] . '" data-post-type="' . $row['topic_name'] . '">';
    echo '<div class="card-content">';
    echo '<h3 class="card-title">' . $row['post_title'] . '</h3>';
    echo '<p class="card-date">' . $row['post_date'] . '</p>';
    echo '<p class="card-topic">' . $row['topic_name'] . '</p>';
    echo '<p class="card-author">' . $row['account_name'] . '</p>';
    echo '</div>';
    echo '</div>';
  }
} else {
  echo '<p>No posts found.</p>';
}

mysqli_free_result($postsResult);
?>
</div>
</div>
</section>
</main>

<div class="section"></div>

<script type="module" src="./src/nav.js"></script>
<script type="module" src="./src/card-toggle.js"></script>
<script type="module" src="./src/grid&list.js"></script>

<script>
const filterAuthor = document.getElementById('filter-author');

filterAuthor.addEventListener('change', function() {
if (filterAuthor.value === 'BSIT') {
filterAuthor.disabled = true;
} else {
filterAuthor.disabled = false;
}
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
const filterAuthor = document.getElementById('filter-author');
const filterTopic = document.getElementById('filter-topic');

filterAuthor.addEventListener('change', filterPosts);
filterTopic.addEventListener('change', filterPosts);

function filterPosts() {
const author = filterAuthor.value;
const topic = filterTopic.value;

const posts = document.querySelectorAll('.card');
let foundPosts = 0; // Track the number of matching posts

posts.forEach(function(post) {
const postAuthor = post.getAttribute('data-author');
const postTopic = post.getAttribute('data-post-type');

const displayAuthor = (author === 'all' || author === postAuthor);
const displayTopic = (topic === 'all' || topic === postTopic);

if (displayAuthor && displayTopic) {
  post.style.display = 'block';
  foundPosts++; // Increment the count for each matching post
} else {
  post.style.display = 'none';
}
});

// Check if no matching posts were found
const noPostsFoundMessage = document.getElementById('no-posts-found');
if (foundPosts === 0) {
noPostsFoundMessage.style.display = 'block'; // Display the "No posts found" message
} else {
noPostsFoundMessage.style.display = 'none'; // Hide the "No posts found" message
}
}
});
</script>

<script>
const heroVideo = document.getElementById('hero-department-video');
const nav = document.querySelector('nav');
const secondNav = document.querySelector('.second-nav');
const heroVideoBottom = heroVideo.getBoundingClientRect().bottom;
const threshold = 100; // Adjust this value as needed

function handleScroll() {
const scrollPosition = window.scrollY || window.pageYOffset;
const viewportHeight= window.innerHeight;

if (scrollPosition + viewportHeight > heroVideoBottom) {
  nav.style.opacity = '0';
  nav.style.pointerEvents = 'none';
} else {
  nav.style.opacity = '1';
  nav.style.pointerEvents = 'auto';
}

if (scrollPosition > threshold) {
  nav.style.top = '-136px';
  secondNav.style.top = '0';
} else {
  nav.style.top = '0';
  secondNav.style.top = '136px';
}
}

function debounce(func, delay) {
let timeoutId;
return function () {
  clearTimeout(timeoutId);
  timeoutId = setTimeout(func, delay);
};
}

const debouncedHandleScroll = debounce(handleScroll, 10);
window.addEventListener('scroll', debouncedHandleScroll);
</script>

<?php include '../html_utils/footer.php';?>