<?php include './html_utils/header.php';?>

    <!-- Hero Section -->
    <main >


<section id="hero" class="hero">
  <video id="hero-video" autoplay muted loop>
    <source src="./public/hero/psu.mp4" type="video/mp4">
  </video>
  <div class="hero-content">
    <h2>Welcome to Palawan State University</h2>
    <h1>Brooke's Point Campus</h1>
    <p>The most sustainable and eco-friendly school in the Philippines</p>
    <button><a href="#">Explore More</a></button>
  </div>
</section>





      <div class="section"></div>

      <section id="news-events">
        <h2 class="section-title">News and Events</h2>
        <!-- Main Featured Post -->
        <div class="news-events container btn">
        <div class="main-featured">
        <?php include './admin/php/display_post_main_featured.php'; ?>

        </div>
    
        <!-- Sub Featured Posts -->
        <div class="sub-featured sub-featured-container">
        <?php include './admin/php/display_post_sub_featured.php'; ?>

        </div>
      
      
          <button><a href="news&events.php">View All News and Events</a></button>
    
      </div>
      </section>
        

     
    
    <!-- <section class="container">
      <div class="announcement-section btn">
        <h2>Announcements</h2>
  
        <div class="filter-section">
          <label for="announcement-filter">Filter by:</label>
          <select id="announcement-filter">
            <option value="all">All Announcements</option>
            <option value="admission">Admission Office</option>
            <option value="bsit">BSIT Department</option>
          </select>
  
          <label for="announcement-order">Order by:</label>
          <select id="announcement-order">
            <option value="recent">Recent</option>
            <option value="featured">Featured</option>
          </select>
        </div>
  
        <div class="wrapper"> 
          <i id="left" class="fas fa-angle-left"></i>
          <ul class="carousel"> 

            <li class="card">
              <h3>Admission Office</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </li>
            <li class="card">
              <h3>BSIT Department</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </li>
            <li class="card">
              <h3>Featured Announcement</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </li>
            <li class="card">
              <h3>Recent Announcement</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </li>
            
          </ul>
          <i id="right" class="fas fa-angle-right"></i>
        </div>   
        <button><a href="news&events.html">View All Announcements</a></button>    
      </div>
    </section> -->
    



  <div class="section"></div>


  <section class="courses">
  <div class="container">
    <h2 class="section-title">Programs Offered</h2>
    <div class="wrapper"> 
      <i id="left" class="fas fa-angle-left"></i>
      <ul class="carousel">
        <li class="course-card btn-transparent">
          <img src="./public/programs/bscrim.jpg" alt="Bachelor of Science in Criminology" draggable="false">
          <h3>Bachelor of Science in Criminology</h3>
          <div class="course-department">
            <p>Department: Criminology</p>
          </div>
          <button class="view-button" data-department="criminology">View Department</button>
        </li>
        <li class="course-card btn-transparent">
          <img src="./public/programs/bsba.jpg" alt="Bachelor of Science in Business Administration" draggable="false">
          <h3>Bachelor of Science in Business Administration</h3>
          <div class="course-department">
            <p>Department: Business Administration</p>
          </div>
          <button class="view-button" data-department="business-administration">View Department</button>
        </li>
        <li class="course-card btn-transparent">
          <img src="./public/programs/bshrm.jpg" alt="Bachelor of Science in Hospitality Management" draggable="false">
          <h3>Bachelor of Science in Hospitality Management</h3>
          <div class="course-department">
            <p>Department: Hospitality Management</p>
          </div>
          <button class="view-button" data-department="hospitality-management">View Department</button>
        </li>
        <li class="course-card btn-transparent">
          <img src="./public/programs/bsagri.jpg" alt="Bachelor of Science in Agriculture" draggable="false">
          <h3>Bachelor of Science in Agriculture</h3>
          <div class="course-department">
            <p>Department: Agriculture</p>
          </div>
          <button class="view-button" data-department="agriculture">View Department</button>
        </li>
        <li class="course-card btn-transparent">
          <img src="./public/programs/bsit.jpg" alt="Bachelor of Science in Information Technology" draggable="false">
          <h3>Bachelor of Science in Information Technology</h3>
          <div class="course-department">
            <p>Department: Information Technology</p>
          </div>
          <button class="view-button" data-department="information-technology">View Department</button>
        </li>
        <li class="course-card btn-transparent">
          <img src="./public/programs/beed.jpg" alt="Bachelor of Elementary Education" draggable="false">
          <h3>Bachelor of Elementary Education</h3>
          <div class="course-department">
            <p>Department: Elementary Education</p>
          </div>
          <button class="view-button" data-department="elementary-education">View Department</button>
        </li>
        <li class="course-card btn-transparent">
          <img src="./public/programs/bsed.jpg" alt="Bachelor of Secondary Education" draggable="false">
          <h3>Bachelor of Secondary Education</h3>
          <div class="course-department">
            <p>Department: Secondary Education</p>
          </div>
          <button class="view-button" data-department="secondary-education">View Department</button>
        </li>
        <!--Add more program cards here -->
      </ul>
      <i id="right" class="fas fa-angle-right"></i>
    </div>
    <div class="btn">
      <button><a href="./academic_programs.php">View All Programs</a></button>
    </div>
  </div>
</section>



<!-- <section class="programs">
  <div class="container">
    <ul class="program-list">
      <li class="program-card">
        <h3>Bachelor of Science in Criminology</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Science in Business Administration</h3>
        <ul class="subprogram-list">
          <li>Human Resource Development Management</li>
          <li>Financial Management</li>
          <li>Marketing Management</li>
          <li>Management Accounting</li>
        </ul>
      </li>
      <li class="program-card">
        <h3>Bachelor of Science in Hospitality Management</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Science in Agriculture</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Science in Information Technology</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Elementary Education</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Secondary Education</h3>
        <ul class="subprogram-list">
          <li>English</li>
          <li>Mathematics</li>
        </ul>
      </li>
    </ul>
  </div>
</section> -->

    

  
  <div class="section"></div>


  <section id="faq" class="container">
    <h2 class="section-title">Frequently Asked Questions</h2>
    <div class="faq-wrapper">
      <div class="faq-column">
        <div class="faq-item">
          <h3 class="faq-question">Question 1: What are the admission requirements?</h3>
          <div class="faq-answer">
            <p>Answer 1: To apply for admission, you need to submit your high school transcripts, completed application form, recommendation letters, and any additional requirements specified by the university. Please visit our Admissions page for detailed information.</p>
          </div>
        </div>
        <div class="faq-item">
          <h3 class="faq-question">Question 2: Are there any scholarships available?</h3>
          <div class="faq-answer">
            <p>Answer 2: Yes, we offer various scholarships and financial aid options for eligible students. Our scholarship programs include academic scholarships, sports scholarships, and need-based financial aid. Visit our Scholarships page for more information on available opportunities.</p>
          </div>
        </div>
      </div>
      <div class="faq-column">
        <div class="faq-item">
          <h3 class="faq-question">Question 3: How do I contact the university's administration?</h3>
          <div class="faq-answer">
            <p>Answer 3: You can reach out to our administration by visiting the Contact Us page on our website. We provide contact information for various departments, including admissions, student services, and general inquiries. Feel free to email us or give us a call, and we'll be happy to assist you.</p>
          </div>
        </div>
        <div class="faq-item">
          <h3 class="faq-question">Question 4: What programs and majors does the university offer?</h3>
          <div class="faq-answer">
            <p>Answer 4: Palawan State University offers a wide range of undergraduate and graduate programs across multiple disciplines. Some of our popular majors include Business Administration, Computer Science, Education, Environmental Science, and Nursing. Explore our Programs page to see the full list of academic offerings.</p>
          </div>
        </div>
      </div>
      <div class="faq-column">
        <div class="faq-item">
          <h3 class="faq-question">Question 5: Can international students apply to the university?</h3>
          <div class="faq-answer">
            <p>Answer 5: Yes, we welcome applications from international students. We have specific admissions requirements and procedures for international applicants. Please refer to our International Students page for detailed information on application guidelines, English language proficiency requirements, and visa support.</p>
          </div>
        </div>
        <div class="faq-item">
          <h3 class="faq-question">Question 6: Are there on-campus housing facilities available?</h3>
          <div class="faq-answer">
            <p>Answer 6: Yes, we provide on-campus housing options for students. Our university dormitories offer comfortable accommodations with various amenities, such as Wi-Fi access, study areas, and recreational facilities. Availability may vary, so we recommend applying for housing early. Visit our Housing page for more details.</p>
          </div>
        </div>
      </div>
    </div>
</section>

<div class="section"></div>

  </main>

<script type="module" src="./src/nav.js"></script>
<script type="module" src="./src/carousel.js" defer></script>
<script type="module" src="./src/script.js" defer></script>
<script type="module" src="./src/card-toggle.js"></script>
<script type="module" src="./src/grid&list.js"></script>



  <script>
const hero = document.querySelector('.hero');
const video = document.querySelector('#hero-video');
const content = document.querySelector('.hero-content');

const observer = new IntersectionObserver(function(entries) {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      content.style.position = 'sticky';
      content.style.top = '180px';
      content.style.marginTop = '-136px';
    } else {
      content.style.position = 'absolute';
      content.style.top = 'auto';
      content.style.marginTop = '0';
    }
  });
});

observer.observe(hero);
  </script>

  
  


  <?php include './html_utils/footer.php';?>