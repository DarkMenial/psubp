<?php include './html_utils/header.php';?>


<section class="container__pages container__banner">
    <div>
      <div class="banner__content">
        <h2>Organizational Chart</h2>
      </div>
      <img src="public/banner.jpg" alt="Banner Image" />
      <div class="banner__overlay"></div>
    </div>
  </section>



<section id="org-chart" class="org-chart">
  <div class="container">
    <!-- President Container -->
    <div class="president-container">
      <!-- University President -->
      <div class="profile-card president">
        <div class="profile-photo-wrapper">
          <img src="./public/course3.jpg" alt="James Smith" class="profile-photo">
        </div>
        <div class="profile-info">
          <h3 class="profile-name">James Smith</h3>
          <p class="profile-position">University President</p>
          <p class="profile-contact">Email: <a href="mailto:james.smith@example.com">james.smith@example.com</a></p>
          <p class="profile-contact">Phone: (123) 456-7890</p>
        </div>
      </div>
    </div>

    <!-- Faculty Profiles -->
    <div class="level-wrapper">
      <div class="level">
        <div class="profile-card">
          <div class="profile-photo-wrapper">
            <img src="./public/course1.jpg" alt="Emily Johnson" class="profile-photo">
          </div>
          <div class="profile-info">
            <h3 class="profile-name">Emily Johnson</h3>
            <p class="profile-position">Dean of Arts & Sciences</p>
            <p class="profile-contact">Email: <a href="mailto:emily.johnson@example.com">emily.johnson@example.com</a></p>
            <p class="profile-contact">Phone: (123) 456-7891</p>
          </div>
        </div>

        <div class="profile-card">
          <div class="profile-photo-wrapper">
            <img src="./public/course2.jpg" alt="Michael Brown" class="profile-photo">
          </div>
          <div class="profile-info">
            <h3 class="profile-name">Michael Brown</h3>
            <p class="profile-position">Dean of Engineering</p>
            <p class="profile-contact">Email: <a href="mailto:michael.brown@example.com">michael.brown@example.com</a></p>
            <p class="profile-contact">Phone: (123) 456-7892</p>
          </div>
        </div>

        <div class="profile-card">
          <div class="profile-photo-wrapper">
            <img src="path_to_dean3_image.jpg" alt="Sarah Wilson" class="profile-photo">
          </div>
          <div class="profile-info">
            <h3 class="profile-name">Sarah Wilson</h3>
            <p class="profile-position">Dean of Business</p>
            <p class="profile-contact">Email: <a href="mailto:sarah.wilson@example.com">sarah.wilson@example.com</a></p>
            <p class="profile-contact">Phone: (123) 456-7893</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Additional Faculty Profiles -->
    <div class="level-wrapper">
      <div class="level">
        <div class="profile-card">
          <div class="profile-photo-wrapper">
            <img src="path_to_department_head1_image.jpg" alt="David Miller" class="profile-photo">
          </div>
          <div class="profile-info">
            <h3 class="profile-name">David Miller</h3>
            <p class="profile-position">Head of Computer Science</p>
            <p class="profile-contact">Email: <a href="mailto:david.miller@example.com">david.miller@example.com</a></p>
            <p class="profile-contact">Phone: (123) 456-7894</p>
          </div>
        </div>

        <div class="profile-card">
          <div class="profile-photo-wrapper">
            <img src="path_to_department_head2_image.jpg" alt="Laura Davis" class="profile-photo">
          </div>
          <div class="profile-info">
            <h3 class="profile-name">Laura Davis</h3>
            <p class="profile-position">Head of Biology</p>
            <p class="profile-contact">Email: <a href="mailto:laura.davis@example.com">laura.davis@example.com</a></p>
            <p class="profile-contact">Phone: (123) 456-7895</p>
          </div>
        </div>

        <div class="profile-card">
          <div class="profile-photo-wrapper">
            <img src="path_to_department_head3_image.jpg" alt="Daniel Wilson" class="profile-photo">
          </div>
          <div class="profile-info">
            <h3 class="profile-name">Daniel Wilson</h3>
            <p class="profile-position">Head of Business Administration</p>
            <p class="profile-contact">Email: <a href="mailto:daniel.wilson@example.com">daniel.wilson@example.com</a></p>
            <p class="profile-contact">Phone: (123) 456-7896</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>




<?php include './html_utils/footer.php';?>