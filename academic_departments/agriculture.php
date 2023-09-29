<?php include '../html_utils/header_department.php'; ?>
<div><h2>AGRICULTURE DEPARTMENT</h2></div>

    </div>
  </nav>
</header>

<?php include '../html_utils/header_department_second_nav.php'; ?>


<section id="hero-department" class="hero-department">
  <video id="hero-department-video" autoplay muted loop>
    <!-- <source src="../public/hero/bsagri.mp4" type="video/mp4"> -->
  </video>
</section>

<div class="section"></div>




<section class="container" id="about">
<h1 class="section-title">About Us</h1>
<div class="section"></div>

<div class="sectionline"></div>

    <div class="container__sidemain">
      <div class="sidebar__sticky">
        <button class="nav-button" data-section="mission">Mission</button>
        <button class="nav-button" data-section="programs&courses">Programs & Courses</button>
        <button class="nav-button" data-section="quality-policy">Quality Policy</button>
        <button class="nav-button" data-section="faculty&research">Faculty & Research</button>
        <button class="nav-button" data-section="facilities&resources">Facilities & Resourses</button>
        <button class="nav-button" data-section="community-engagement">Community Engagement</button>
        <button class="nav-button" data-section="accreditation&recognition">Accreditation & Recognition</button>
      </div>

      <div class="main">
        <section id="mission">
          <div class="container page_container">
            <h1>Mission</h1>
            <p> Our mission is to educate and empower the next generation of agricultural professionals, 
                preparing them to address global food security challenges, promote sustainable practices, 
                and contribute to the overall well-being of communities. We are committed to cultivating 
                a deep understanding of agricultural sciences, fostering critical thinking, and promoting 
                ethical leadership.
            </p>
               </div>
        </section>

<div class="sectionline"></div>
<div class="section"></div>


        <section id="programs&courses">
          <div class="container page_container">
            <h1>Programs & Courses</h1>
            <p>    We offer a wide range of programs and courses designed to meet the diverse interests 
                   and career goals of our students. From crop science to animal husbandry, agribusiness 
                   to sustainable agriculture, our curriculum is designed to provide a comprehensive 
                   education in various agricultural disciplines. Our courses incorporate hands-on learning, 
                   fieldwork, and internships to ensure practical application of theoretical knowledge.
            </p>

            </div>
            </section>

<div class="section"></div>
<div class="sectionline"></div>
<div class="section"></div>
          

          <section id="quality-policy">
            <div class="container page_container">
              <h1>Quality Policy</h1>
              <p>We Provide equal opportunities for relevant, innovative and
                internationally recognized higher education programs and advanced
                studies for lifelong learning and sustainable development
                <br><br>
                We Strongly commit to deliver excellence in instruction, research,
                extension and transnational programs in order to meet the
                increasing levels of stakeholder demand as well as statutory and
                regulatory requirements.
                <br><br>
                The University shall continue to monitor, review and upgrade its
                quality management system to ensure compliance with national and
                international standards and requirements.</p>
            </div>
          </section>



<div class="section"></div>
<div class="sectionline"></div>
<div class="section"></div>

<section id="faculty&research">
            <div class="container page_container">
              <h1>Faculty & Research</h1>
              <p>Our faculty members are experts in their respective fields, with 
                extensive industry experience and a strong dedication to research 
                and teaching. They actively contribute to cutting-edge research 
                projects, partnering with industry stakeholders and fellow 
                researchers to address key challenges and opportunities in agriculture. 
                Our department encourages student involvement in research initiatives, 
                providing valuable experiential learning opportunities.</p>
            </div>
          </section>

<div class="section"></div>
<div class="sectionline"></div>
<div class="section"></div>

<section id="facilities&resources">
            <div class="container page_container">
              <h1>Facilities & Resources</h1>
              <p>We take pride in offering modern facilities and resources to 
                support student learning and research endeavors. Our department 
                houses well-equipped laboratories, greenhouses, and farms, providing 
                students with hands-on experiences in agricultural practices, data 
                analysis, and experimentation. We also provide access to specialized 
                software, libraries, and online resources to enhance the learning experience.</p>
            </div>
          </section>

<div class="section"></div>
<div class="sectionline"></div>
<div class="section"></div>

<section id="community-engagement">
            <div class="container page_container">
              <h1>Community Engagements</h1>
              <p>We believe in fostering a sense of community and collaboration within our 
                department. Our students actively engage in community outreach programs, 
                working with local farmers, organizations, and policymakers to promote
                 sustainable agriculture, improve agricultural practices, and address 
                 pressing issues related to food security. We encourage students to 
                 participate in agricultural clubs, competitions, and conferences, 
                 providing opportunities for networking and professional development.</p>
            </div>
          </section>


<div class="section"></div>
<div class="sectionline"></div>
<div class="section"></div>

<section id="accreditation&recognition">
            <div class="container page_container">
              <h1>Accreditation & Recognition</h1>
              <p>Our Agriculture Department is accredited by [mention relevant accrediting bodies or institutions]. 
                This recognition affirms our commitment to maintaining high educational standards and ensuring the 
                quality of our programs.</p>
            </div>
          </section>

        </div>
      </div>
<div class="section"></div>
<div class="sectionline"></div>
<div class="section"></div>

      
    </section> 


<main>
  <section id="news-events">
<h1 class="section-title">News & Events</h1>
<div class="section"></div>


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
          <!-- <label for="filter-author">Author:</label> -->
          <select id="filter-author" name="filter-author" disabled>
            <?php
            $authorsQuery = "SELECT DISTINCT account_name FROM accounts";
            $authorsResult = mysqli_query($conn, $authorsQuery);

            while ($username = mysqli_fetch_assoc($authorsResult)) {
              $authorName = $username['account_name'];
              $formattedAuthorName = strtoupper(str_replace('_', ' ', $authorName));

              if ($authorName === 'BSAGRI') {
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

        <?php include '../admin/php/display_post_card.php'; ?>
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
    if (filterAuthor.value === 'BSAGRI') {
      filterAuthor.disabled = true;
    } else {
      filterAuthor.disabled = false;
    }
  });
</script>

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
    const posts = document.querySelectorAll('.card');

    filterAuthor.addEventListener('change', filterPosts);
    filterTopic.addEventListener('change', filterPosts);

    function filterPosts() {
      const author = filterAuthor.value;
      const topic = filterTopic.value;

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

    // Filter posts initially to display only BSIT posts
    filterPosts();
  });
</script>

<!-- <script>
  const heroVideo = document.getElementById('hero-department-video');
  const nav = document.querySelector('nav');
  const secondNav = document.querySelector('.second-nav');
  const heroVideoBottom = heroVideo.getBoundingClientRect().bottom;
  const threshold = 0; // Adjust this value as needed

  function handleScroll() {
    const scrollPosition = window.scrollY || window.pageYOffset;
    const viewportHeight = window.innerHeight;

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
    return function() {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(func, delay);
    };
  }

  const debouncedHandleScroll = debounce(handleScroll, 10);
  window.addEventListener('scroll', debouncedHandleScroll);
</script> -->


<script>
const secondNav = document.querySelector('.second-nav');
const threshold = 100; // Adjust this value as needed

secondNav.classList.toggle('fixed');

function handleScroll() {
  const scrollPosition = window.scrollY || window.pageYOffset;

  if (scrollPosition > threshold) {
    secondNav.classList.add('fixed');
  } else {
    secondNav.classList.remove('fixed');
  }
}

window.addEventListener('scroll', handleScroll);

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const navLinks = document.querySelectorAll('.second-nav-list a');
  const sections = document.querySelectorAll('section');

  function setActiveSection() {
    const scrollPosition = window.scrollY || window.pageYOffset;
    const windowHeight = window.innerHeight;
    const offset = 136; // Adjust this value as needed

    for (let i = 0; i < sections.length; i++) {
      const section = sections[i];
      const sectionTop = section.offsetTop - offset;
      const sectionBottom = sectionTop + section.offsetHeight;

      if (scrollPosition + windowHeight / 2 >= sectionTop && scrollPosition + windowHeight / 2 < sectionBottom) {
        const sectionId = section.getAttribute('id');
        const correspondingLink = document.querySelector(`[data-section="${sectionId}"]`);
        correspondingLink.classList.add('active');
      } else {
        const correspondingLink = document.querySelector(`[data-section="${section.id}"]`);
        correspondingLink.classList.remove('active');
      }
    }
  }

  function handleScroll() {
    setActiveSection();
  }

  function handleResize() {
    setActiveSection();
  }

  window.addEventListener('scroll', handleScroll);
  window.addEventListener('resize', handleResize);

  setActiveSection(); // Set active section on page load

  // Remove active class from other links when a link is clicked
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      navLinks.forEach(otherLink => otherLink.classList.remove('active'));
    });
  });
});

</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Get the announcements link and filter topic dropdown
    const announcementsLink = document.getElementById('announcements-link');
    const filterTopic = document.getElementById('filter-topic');

    // Function to select the "smmo8ibcement" topic in the filter dropdown
    function selectAnnouncementsTopic() {
      const topicValue = 'Announcement';

      // Set the filter topic value to "smmo8ibcement"
      filterTopic.value = topicValue;

      // Trigger a change event on the filter topic dropdown to filter posts
      const event = new Event('change');
      filterTopic.dispatchEvent(event);
    }

    // Add a click event listener to the announcements link
    announcementsLink.addEventListener('click', selectAnnouncementsTopic);
  });
</script>


<?php include '../html_utils/footer.php'; ?>