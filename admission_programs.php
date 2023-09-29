<<<<<<< HEAD
<?php include './html_utils/header.php';?>


<section class="programs">
  <div class="container">
    <h2>Academic Programs Offered</h2>
    <ul class="program-list">
      <li class="program-card">
        <h3>Bachelor of Arts in Political Science</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Science in Criminology</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Science in Entrepreneurship</h3>
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
        <h3>Bachelor of Science in Public Administration</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Science in Hospitality Management</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Science in Tourism/BS in Tourism Management</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Science in Agriculture</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Science in Computer Science</h3>
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
      <li class="program-card">
        <h3>Bachelor of Electrical Engineering Technology</h3>
      </li>
      <li class="program-card">
        <h3>Bachelor of Mechanical Engineering Technology</h3>
      </li>
    </ul>
  </div>
</section>  

<?php include './html_utils/footer.php';?>
=======
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/programs-offered.css" />
    <link rel="stylesheet" href="../styles/modern-normalize.css" />
    <link rel="stylesheet" href="../styles/news&events.css" />
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../styles/utils.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <title>University Website</title>
  </head>
<body>
  <header class="header">
    <nav>
      <!-- Logo -->
      <div class="nav-content container">
        <a href="index.html" class="logo-wrapper td-none">
          <div class="logo-img-wrapper">
            <img src="../public/logo.png" alt="University Logo" />
          </div>
          <div><span><strong>PSU</strong></span>BP</div>
        </a>
        
      <div class="header__nav-list">
        <!-- Secondary NavList (upper) -->
        <ul class="secondary-list">
          <li>
            <a href="./about.html">About</a>
              <ul class="dropdown">
                <li><a href="../about.html#mission&vission">Mission & Vission</a></li>
                    <li><a href="../about.html#history">History</a></li>
                    <li><a href="../about.html#quality-policy">Quality Policy</a></li>
                    <li><a href="faculty&staff.html#faculty-and-staff">Faculty and Staff</a></li>
                    <li><a href="../about.html#organizationl-chart">Organizational Chart</a></li>
                    <li><a href="#contact-us#">Contact Us</a>
                       <ul class="has-dropdown sub-dropdown social-media-icons">
                          <li><a href="#" class="social-icon"><i class="fab fa-facebook"></i></a></li>
                          <li><a href="#" class="social-icon"><i class="fab fa-instagram"></i></a></li>
                          <li><a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                      </li>
          </li>
        </ul>
              
           
    
          <li>
            <a href="news&events.html">News & Events</a>
            <!-- <ul class="dropdown">
              <li><a href="#">Admission Office Announcements</a></li>
              <li><a href="#">Academic Department News</a>
                <ul class="has-dropdown sub-dropdown">
                  <li><a href="./academic_department/bsed.html#N&E">BSED</a></li>
                  <li><a href="./academic_department/beed.html#N&E">BEED</a></li>
                  <li><a href="./academic_department/bscrim.html#N&E">BSCRIM</a></li>
                  <li><a href="./academic_department/bsit.html#N&E">BSIT</a></li>
                  <li><a href="./academic_department/bshm.html#N&E">BSHM</a></li>
                  <li><a href="./academic_department/bsagri.html#N&E">BSAGRI</a></li>
                  <li><a href="./academic_department/bsba.html#N&E">BSBA</a></li>
                </ul>
              </li>
              <li><a href="pta.html#N&E">PTA News & Events</a></li>
            </ul> -->
          </li>
          <li>
            <a href="directory.html">Directory</a>
          </li>
        </ul>
        <!-- Main NavList (lower) -->
        <ul class="main-list">


          <!-- <li>
            <div class="search-container">
              <input type="text" id="search-bar" placeholder="Search">
            </div>
            <div class="search-button"><i id="search-icon" class="fa fa-search"></i></div>
          </li> -->

          <li>
            <a href="#">ACADEMICS</a>
            <ul class="dropdown">
              <li><a href="./academic_calendar.html">Academic Calendar</a></li>
              <li><a href="./academic_departments.html">Academic Departments</a></li>
              <li><a href="./admission_programs.html">Programs Offered</a></li>
              <li><a href="academics.html#undergraduate-programs">Programs Head</a></li>  
              <!-- <li><a href="academics.html#majors">Majors</a></li> -->
            </ul>
          </li>

          <li>  
            <a href="admission.html#admissions">ADMISSIONS</a>
          <ul class="dropdown">
            <li><a href="./admission_requirements.html">Admission Requirements</a></li>
            <li><a href="./admission_process.html">Admission Process</a></li>
            <li><a href="./academic_calendar.html">Academic Calendar</a></li>
            <li><a href="./portals.html">Portals</a></li>
            </ul>
          </li>  
          <li><a href="student-affairs.html#student-affairs">STUDENT AFFAIRS</a>
            <ul class="dropdown">
                  <li><a href="student-government.html#student-government">Student Government</a></li>
                  <li><a href="#">Student Resources</a></li>
            </ul>
          </li>
        </ul>
      </div>
      </div>
    </nav>
    
  </header>


  <section class="container__pages container__banner">
    <div>
      <div class="banner__content">
        <h2>Acedmic Programs Offered</h2>
      </div>
      <img src="/banner.jpg" alt="Banner Image" />
      <div class="banner__overlay"></div>
    </div>
  </section>

<main class="container__firstpage">
  <section class="programs">
    <div class="container">
      <!-- <h2>Academic Programs Offered</h2> -->
      <ul class="program-list">
        <li class="program-card">
          <h3>Bachelor of Arts in Political Science</h3>
        </li>
        <li class="program-card">
          <h3>Bachelor of Science in Criminology</h3>
        </li>
        <li class="program-card">
          <h3>Bachelor of Science in Entrepreneurship</h3>
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
          <h3>Bachelor of Science in Public Administration</h3>
        </li>
        <li class="program-card">
          <h3>Bachelor of Science in Hospitality Management</h3>
        </li>
        <li class="program-card">
          <h3>Bachelor of Science in Tourism/BS in Tourism Management</h3>
        </li>
        <li class="program-card">
          <h3>Bachelor of Science in Agriculture</h3>
        </li>
        <li class="program-card">
          <h3>Bachelor of Science in Computer Science</h3>
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
        <li class="program-card">
          <h3>Bachelor of Electrical Engineering Technology</h3>
        </li>
        <li class="program-card">
          <h3>Bachelor of Mechanical Engineering Technology</h3>
        </li>
      </ul>
    </div>
  </section>
  
</main>

  
    
  <footer class="footer">
    <div class="container">
      <p>&copy; 2023 My Website. All Rights Reserved.</p>
      <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
  </div>
  </footer>

  <script type="module" src="./src/main.js"></script>
</body>
</html>
>>>>>>> origin/main
