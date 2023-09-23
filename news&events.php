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
<div class="container__sidemain">
    <div class="sidebar__sticky">
        <div class="filter-section">
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
      

      <div class="display-toggle btn">
        <button class="toggle-btn active" data-display-type="grid"><i class="fas fa-th-large"></i></button>
        <button class="toggle-btn" data-display-type="list"><i class="fas fa-list"></i></button>
      </div>
      
            </div>
      
    </div>
    
<div class="main">
    
        <ul id="announcements" class="grid-view list-view announcement-list">

      <?php include './admin/php/display_post_card.php';?>

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
  function filterPosts() {
    // Get the selected filter values
    var authorFilter = document.getElementById("filter-author").value;
    var postFilter = document.getElementById("filter-post").value;

    // Get all the card elements
    var cards = document.querySelectorAll(".card");

    // Loop through each card and apply the filter
    for (var i = 0; i < cards.length; i++) {
      var card = cards[i];

      // Get the author and post type of the card
      var author = card.getAttribute("data-author");
      var postType = card.getAttribute("data-post-type");

      // Check if the card matches the selected filters
      var authorMatch = authorFilter === "all" || author === authorFilter;
      var postMatch = postFilter === "" || postType === postFilter;

      // Show or hide the card based on the filter results
      card.style.display = authorMatch && postMatch ? "block" : "none";
    }
  }

  // Add event listeners to the filter elements
  document.getElementById("filter-author").addEventListener("change", filterPosts);
  document.getElementById("filter-post").addEventListener("change", filterPosts);
</script>


<?php include './html_utils/footer.php';?>