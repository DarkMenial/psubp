<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../styles/modern-normalize.css">
  <link rel="stylesheet" href="../styles/manage-post.css">
  <link rel="stylesheet" href="../styles/dashboard.css">
  <link rel="stylesheet" href="../styles/post.css">
  <link rel="stylesheet" href="../styles/utils.css">
  <link rel="stylesheet" href="../styles/style.css">  
  <link rel="stylesheet" href="../styles/nav.css">  
  <link rel="stylesheet" href="../styles/fontawesome/css/fontawesome.min.css">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link rel="stylesheet" href="../styles/create-post.css">
  <link rel="stylesheet" href="../styles/create-profile.css">
  <link rel="stylesheet" href="../../psubp/styles/all.min.css" />




  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



</head>
<body class = "admin-page-wrapper">

<aside class="sidebar">
  <div class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
  </div>
  <ul class="sidebar-menu">
    <li><a href="./dashboard.php"><i class="fas fa-tachometer-alt"></i><span class="menu-text">DASHBOARD</span></a></li>
    <li><a href="./manage_posts.php"><i class="fas fa-pencil-alt"></i><span class="menu-text">POST</span></a></li>
    <li><a href="./manage_profiles.php"><i class="fas fa-users"></i><span class="menu-text">PROFILES</span></a></li>
    <li><a href="./manage_academic_calendar.php"><i class="fas fa-calendar-alt"></i><span class="menu-text">ACADEMIC CALENDAR</span></a></li> 
    <li><a href="./manage_users.php"><i class="fas fa-user-cog"></i><span class="menu-text">MANAGE USERS</span></a></li>
    <li><a href="./manage_accounts.php"><i class="fas fa-users-cog"></i><span class="menu-text">ACCOUNTS</span></a></li>
    <li><a href="#"><i class="fas fa-archive"></i><span class="menu-text">ARCHIVE</span></a></li>
    <li><a href="#"><i class="fas fa-info-circle"></i><span class="menu-text">INFORMATION</span></a></li>
    <li><a href="#"><i class="fas fa-database"></i><span class="menu-text">BACKUP/RESTORE</span></a></li>
    <li><a href="./logout.php"><i class="fas fa-sign-out-alt"></i><span class="menu-text">LOGOUT</span></a></li>
  </ul>
</aside>


<div class = "content-wrapper">

  <div class="top-nav">
    <div class="nav-contents">
    <a href="../index.php">
    <div class="logo">
    
        <img src="../public/logo.png" alt="Logo">
        <span>PSU</span>
        BP
    
</div>
</a>
      <div class="right-section">
        <div class="user-profile">
          <div class="account-icon">
            <i class="fas fa-user"></i>
          </div>
          <div class="user-info">
            <span class="username"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'No username found'; ?></span>
            <i class="fas fa-caret-down"></i>
          </div>
          <!-- <div class="logout">
            <a href="./logout.php">Logout</a>
          </div> -->
        </div>
      </div>
    </div>
</div>