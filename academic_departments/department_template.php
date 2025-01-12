<section id="hero-department" class="hero-department">
    <video id="hero-department-video" autoplay muted loop>
        <source src="<?php echo $videoSource; ?>" type="video/mp4">
    </video>
</section>

<div class="section"></div>

<section class="container" id="about">
    <h1 class="section-title">About Us</h1>
    <?php include 'about_section.php'; ?>
</section>

<div class="section"></div>

<section class="container" id="people">
    <h1 class="section-title">People</h1>
    <?php include 'sections/people_section.php'; ?>
</section>

<div class="section"></div>

<section class="container" id="news-events">
    <h1 class="section-title">News & Events</h1>
    <?php include 'sections/news_events_section.php'; ?>
</section>

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

    // Function to select the "Announcement" topic in the filter dropdown
    function selectAnnouncementsTopic() {
      const topicValue = 'Announcement';

      // Set the filter topic value to "Announcement"
      filterTopic.value = topicValue;

      // Trigger a change event on the filter topic dropdown to filter posts
      const event = new Event('change');
      filterTopic.dispatchEvent(event);
    }

    // Add a click event listener to the announcements link
    announcementsLink.addEventListener('click', selectAnnouncementsTopic);
  });
</script>

<?php include $_SERVER['DOCUMENT_ROOT'] .'/psubp/html_utils/footer.php';?>