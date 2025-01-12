<?php
// Function to get the department name based on the provided department variable
function getDepartmentFromScript($department) {
    $departments = [
        'agriculture' => 'AGRICULTURE DEPARTMENT',
        'information_technology' => 'INFORMATION TECHNOLOGY DEPARTMENT',
        'criminology' => 'CRIMINOLOGY DEPARTMENT',
        'business_administration' => 'BUSINESS ADMINISTRATION DEPARTMENT',
        'hospitality_management' => 'HOSPITALITY MANAGEMENT DEPARTMENT',
        'elementary_education' => 'ELEMENTARY EDUCATION DEPARTMENT',
        'secondary_education' => 'SECONDARY EDUCATION DEPARTMENT'
    ];

    // Return the correct department name based on the passed variable
    return $departments[$department] ?? 'DEFAULT DEPARTMENT';
}

$departmentHeader = getDepartmentFromScript($department);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/psubp/styles/modern-normalize.css" />
    <link rel="stylesheet" href="/psubp/styles/post.css" />
    <link rel="stylesheet" href="/psubp/styles/academic-calendar.css" />
    <link rel="stylesheet" href="/psubp/styles/news&events.css" />
    <link rel="stylesheet" href="/psubp/styles/style.css" />
    <link rel="stylesheet" href="/psubp/styles/utils.css" />
    <link rel="stylesheet" href="/psubp/styles/nav-department.css" />
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
            <div class="nav-content container">
                <a href="/psubp/index.php" class="logo-wrapper td-none">
                    <div class="logo-img-wrapper">
                        <img src="/psubp/public/logo.png" alt="University Logo" />
                    </div>
                    <div><span><strong>Palawan State University</strong><br></span>Brooke's Point Campus</div>
                </a>
                <div class="vertical-separator"></div>
                <!-- Dynamic department header -->
                <h2><?php echo $departmentHeader; ?></h2>
            </div>
        </nav>
    </header>

    <nav class="second-nav" id="secondNav">
        <div class="container">
            <ul class="second-nav-list">
                <li class="active"><a href="#hero-department" data-section="hero-department">Overview</a></li>
                <li><a href="about.php" data-section="about">About</a></li>
                <li><a href="#people" data-section="people">People</a></li>
                <li><a href="#news-events" data-section="news-events">News & Events</a></li>
                <li><a href="#news-events" data-section="news-events" id="announcements-link">Announcements</a></li>
            </ul>
        </div>
    </nav>

    <!-- Placeholder for department-specific content -->
    <div id="departmentSections">
        <h2 style="display: none;">AGRICULTURE DEPARTMENT</h2>
        <h2 style="display: none;">INFORMATION TECHNOLOGY DEPARTMENT</h2>
        <h2 style="display: none;">EDUCATION DEPARTMENT</h2>
        <!-- Add more department sections as needed -->
    </div>
    
</body>
</html>

<script>
window.addEventListener('DOMContentLoaded', (event) => {
  // Select the navigation element and container__banner element
  const nav = document.querySelector('nav');
  const banner = document.querySelector('.container__banner');

  // Check if the navigation is fixed
  if (nav.classList.contains('fixed')) {
    // Set the margin-top of container__banner to the height of the fixed navigation
    banner.style.marginTop = `${getComputedStyle(nav).height}`;
  } else {
    // Reset the margin-top if the navigation is not fixed
    banner.style.marginTop = '0';
  }
});
</script>
