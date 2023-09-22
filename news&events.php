<?php include './html_utils/header.php';?>





  <section class="container__pages container__banner">
    <div>
      <div class="banner__content">
        <h2>News & Events</h2>
      </div>
      <img src="public/banner.jpg" alt="Banner Image" />
      <div class="banner__overlay"></div>
    </div>
  </section>
  




<div class="section"></div>

<main>

<section id="news-events">
  <!-- Main Featured Post -->
  <div class="news-events container btn">
  <div class="main-featured">

  <?php include './admin/php/display_post_main_featured.php'; ?>

  </div>
</section>




<div class="section"></div>

<section class="container">
    <div id="items-container" class="container__sidemain">
      <div class="sidebar__sticky">
        <div class="filter-section">
          <div class="display-toggle">
            <div class="toggle-btn active" data-display-type="grid"><i class="fas fa-th-large" style="margin-right: 10px;"></i>Grid View</div>
            <div class="toggle-btn" data-display-type="list"><i class="fas fa-list" style="margin-right: 10px; padding: 0;"></i>List View</div>
          </div>
          <label for="filter-author">Author:</label>
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
        <?php include './admin/php/display_post_card.php'; ?>
      </div>
    </div>
  </section>
</main>

<div class="section"></div>


    <script type="module" src="./src/nav.js"></script>
    <script type="module" src="./src/card-toggle.js"></script>
    <script type="module" src="./src/grid&list.js"></script>



    <script>


function expandCard(cardID) {
  const card = document.getElementById(cardID);
  const expandButton = card.querySelector('.expand-button');
  const icon = expandButton.querySelector('i');

  // Toggle the expanded class on the card
  card.classList.toggle('expanded');
  expandButton.classList.toggle('expanded');

  // Toggle the icon class between ellipsis and close
  if (expandButton.classList.contains('expanded')) {
    icon.classList.remove('fa-ellipsis');
    icon.classList.add('fa-times');
  } else {
    icon.classList.remove('fa-times');
    icon.classList.add('fa-ellipsis');
  }

  // Collapse other expanded cards
  const expandedCards = document.querySelectorAll('.card.expanded:not(.moved-down)');
  expandedCards.forEach(expandedCard => {
    if (expandedCard !== card) {
      expandedCard.classList.remove('expanded');
      const otherExpandButton = expandedCard.querySelector('.expand-button');
      const otherIcon = otherExpandButton.querySelector('i');
      otherExpandButton.classList.remove('expanded');
      otherIcon.classList.remove('fa-times');
      otherIcon.classList.add('fa-ellipsis');
    }
  });
}


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






<?php include './html_utils/footer.php';?>