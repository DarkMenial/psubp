<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/psubp/admin/php/db_connect.php';


// Function to fetch asset details based on criteria
function getAssetByCriteria($accountId, $assetType, $assetCategory, $conn) {
  $query = "SELECT file_name FROM assets WHERE account_id = '$accountId' AND asset_type = '$assetType'  AND asset_category = '$assetCategory'";
  $result = mysqli_query($conn, $query);
  if ($result && mysqli_num_rows($result) > 0) {
      $asset = mysqli_fetch_assoc($result);
      return $asset['file_name'];
  }
  return null;
}

// Example criteria values (replace with actual values or retrieve dynamically)
$accountId = 9;
$assetType = 'Photo';
$assetCategory = 'Logo';

// Get the filename from the database based on criteria
$filename = getAssetByCriteria($accountId, $assetType, $assetCategory, $conn);

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../../psubp/styles/modern-normalize.css" />
    <link rel="stylesheet" href="../../../psubp/styles/post.css" />
    <link rel="stylesheet" href="../../../psubp/styles/owl.carousel.min.css" />
    <link rel="stylesheet" href="../../../psubp/styles/owl.theme.default.min.css" />
    <link rel="stylesheet" href="../../../psubp/styles/academic-calendar.css" />
    <link rel="stylesheet" href="../../../psubp/styles/academic-department.css" />
    <link rel="stylesheet" href="../../../psubp/styles/news&events.css" />
    <link rel="stylesheet" href="../../../psubp/styles/style.css" />
    <link rel="stylesheet" href="../../../psubp/styles/footer.css" />
    <link rel="stylesheet" href="../../../psubp/styles/programs&courses.css" />
    <link rel="stylesheet" href="../../../psubp/styles/utils.css" />
    <link rel="stylesheet" href="../../../psubp/styles/nav.css" />
    <link rel="stylesheet" href="../../../psubp/styles/profile-card.css" />
    <link rel="stylesheet" href="../../../psubp/styles/organizational-chart.css" />
    <link rel="stylesheet" href="../../../psubp/styles/all.min.css" />
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
          <a href="/psubp/index.php" class="logo-wrapper td-none">
            <div class="logo-img-wrapper">
            <?php
            if ($filename) {
              // Construct the URL to the asset
              $assetUrl = '/psubp/public/assets/' . $filename;
              echo '<img src="' . $assetUrl . '" alt="University Logo">';
            } else {
              echo '<p>Logo not found.</p>';
            }
            ?>
            </div>
            <div><span><strong>Palawan State University</strong>
            <br></span>Brooke's Point Campus</div>
          </a>
          
        <div class="header__nav-list">
          <!-- Secondary NavList (upper) -->
          <ul class="secondary-list">
            <li>
              <a href="/psubp/about.php">About</a>
                <ul class="dropdown">
                  <li><a href="/psubp/about.php#mission&vission">Mission & Vission</a></li>
                  <li><a href="/psubp/about.php#history" data-section="history">History</a></li>
                      <li><a href="/psubp/about.php#quality-policy">Quality Policy</a></li>
                      <li><a href="/psubp/faculty&staff.php">Faculty and Staff</a></li>
                      <!-- <li><a href="/psubp/organizationl_chart.php">Organizational Chart</a></li> -->
                      <!-- <li><a href="#contact-us#">Contact Us</a>
                         <ul class="has-dropdown sub-dropdown social-media-icons">
                            <li><a href="#" class="social-icon"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="#" class="social-icon"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a></li>
                          </ul>
                        </li> -->
            </li>
          </ul>
                
             
      
            <li>
              <a href="/psubp/news&events.php">News & Events</a>
              <!-- <ul class="dropdown">
                <li><a href="#">Admission Office Announcements</a></li>
                <li><a href="#">Academic Department News</a>
                  <ul class="has-dropdown sub-dropdown">
                    <li><a href="./academic_department/bsed.php#N&E">BSED</a></li>
                    <li><a href="./academic_department/beed.php#N&E">BEED</a></li>
                    <li><a href="./academic_department/bscrim.php#N&E">BSCRIM</a></li>
                    <li><a href="./academic_department/bsit.php#N&E">BSIT</a></li>
                    <li><a href="./academic_department/bshm.php#N&E">BSHM</a></li>
                    <li><a href="./academic_department/bsagri.php#N&E">BSAGRI</a></li>
                    <li><a href="./academic_department/bsba.php#N&E">BSBA</a></li>
                  </ul>
                </li>
                <li><a href="pta.php#N&E">PTA News & Events</a></li>
              </ul> -->
            </li>
            <li>
              <a href="/psubp/people_directory.php">People Directory</a>
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
                <li><a href="/psubp/academic_calendar.php">Academic Calendar</a></li>
                <li><a href="/psubp/programs&courses.php">Academic Programs</a></li>
                <!-- <li><a href="/psubp/academic_departments.php">Academic Departments</a></li> -->
                <li><a href="/psubp/program_heads.php">Programs Head</a></li>  
                <!-- <li><a href="academics.php#majors">Majors</a></li> -->
                <!-- <li><a href="/psubp/portals.php">Portals</a></li> -->
              </ul>
            </li>
  
            <li>  
              <a href="/psubp/admission.php#admissions">ADMISSIONS</a>
            <ul class="dropdown">
              <li><a href="/psubp/admission_requirements.php">Admission Requirements</a></li>
              <li><a href="/psubp/admission_process.php">Admission Process</a></li>
              </ul>
            </li>  
            <!-- <li><a href="/psubp/student-affairs.php#student-affairs">STUDENT AFFAIRS</a>
              <ul class="dropdown">
                    <li><a href="/psubp/student-government.php#student-government">Student Government</a></li>
                    <li><a href="#">Student Resources</a></li>
              </ul>
            </li> -->
          </ul>
        </div>
        </div>
      </nav>
      
    </header>
    