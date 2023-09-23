<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../styles/modern-normalize.css"/>
  <link rel="stylesheet" href="../styles/dashboard.css"/>
  <link rel="stylesheet" href="../styles/faculty&staff.css"/>
  <link rel="stylesheet" href="../styles/utils.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
</head>
<body>
  <nav class="top-nav">
    <div class="nav-content container">
    <div class="logo">
      <img src="../public/logo.png" alt="Logo">
      <span>PSU</span>
      BP
    </div>
    <div class="right-section">
      <div class="user-profile">
        <div class="account-icon">
          <i class="fas fa-user"></i>
        </div>
        <div class="user-info">
          <span class="username">Department Name</span>
          <i class="fas fa-caret-down"></i>
        </div>
        <div class="logout">
          <span>Logout</span>
        </div>
      </div>
    </div>
  </nav>

  <aside class="sidebar container">
    <div class="sidebar-toggle">
      <i class="fas fa-bars"></i>
      </div>
      <ul class="sidebar-menu">
        <li><a href="./dashboard.html"><i class="fas fa-tachometer-alt"></i> DASHBOARD</a></li>
        <li><a href="./posts/index.html"><i class="fas fa-pencil-alt"></i> POST</a></li>
        <!-- <li class="has-dropdown">
          <a href="#"><i class="fas fa-bullhorn"></i> ANNOUNCEMENTS <i class="fas fa-chevron-right"> </i></a>
          <ul class="dropdown-menu">
            <li><a href="#">Main Feature</a></li>
            <li><a href="#">Sub Featured</a></li>
          </ul>
        </li> -->
        <!-- <li><a href="#"><i class="fas fa-images"></i> MEDIACOLLECTION</a></li> -->
        <li class="has-dropdown">
          <a href="#"><i class="fas fa-users"></i> USER MANAGEMENT <i class="fas fa-chevron-right"></i></a>
          <ul class="dropdown-menu">
            <li><a href="#">User Profiles</a></li>
            <li><a href="#">Accounts</a></li>
            <li><a href="#">Roles</a></li>
            <li><a href="#">Permissions</a></li>
          </ul>
        </li>
        <li><a href="./faculty-and-staff.html"><i class="fas fa-chalkboard-teacher"></i> FACULTY & STAFF</a></li>
        <!-- <li><a href="#"><i class="fas fa-sitemap"></i> ORGANIZATIONAL CHART</a></li> -->
        <!-- <li class="has-dropdown">
          <a href="#"><i class="fas fa-clipboard-list"></i> PROGRAMS/DEPARTMENTS <i class="fas fa-chevron-right"></i></a>
          <ul class="dropdown-menu">
            <li><a href="#">Information Technology</a></li>
            <li><a href="#">Education</a></li>
            <li><a href="#">Criminology</a></li>
            <li><a href="#">Business Administration</a></li>
            <li><a href="#">Agriculture</a></li>
            <li><a href="#">Hospitality Management</a></li>
          </ul>
        </li> -->
        <!-- <li><a href="#"><i class="fas fa-chart-bar"></i> ANALYTICS</a></li> -->
        <li><a href="#"><i class="fas fa-archive"></i> ARCHIVE</a></li>
        <li><a href="#"><i class="fas fa-info-circle"></i> INFORMATION</a></li>
        <li><a href="#"><i class="fas fa-database"></i> BACKUP/RESTORE</a></li>
        <li><a href="#"><i class="fas fa-sign-out-alt"></i> LOGOUT</a></li>
      </ul>
      
      
  </aside>


        <main class="page-wrapper"> 
          <section class="content-wrapper">
              <header class="content-wrapper">
                <h1>Faculty & Staff</h1>
                <div class="filters">
                  <input type="text" placeholder="Search...">
                  <select>
                    <option value="">All Positions</option>
                    <option value="professor">Professor</option>
                    <option value="assistant">Assistant</option>
                    <option value="staff">Staff</option>
                  </select>
                  <button>Add Profile</button>
                </div>
              </header>
            
              <table class="faculty-staff-table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Contact</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>John Doe</td>
                    <td>Professor</td>
                    <td>johndoe@example.com</td>
                    <td>
                    <button class="edit-profile-btn">Edit Profile</button>
                      <button>Remove</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Jane Smith</td>
                    <td>Assistant</td>
                    <td>janesmith@example.com</td>
                    <td>
                      <button>Edit Profile</button>
                      <button>Remove</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Michael Johnson</td>
                    <td>Staff</td>
                    <td>michaeljohnson@example.com</td>
                    <td>
                      <button>Edit Profile</button>
                      <button>Remove</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Sarah Williams</td>
                    <td>Professor</td>
                    <td>sarahwilliams@example.com</td>
                    <td>
                      <button>Edit Profile</button>
                      <button>Remove</button>
                    </td>
                  </tr>
                  <tr>
                    <td>David Brown</td>
                    <td>Assistant</td>
                    <td>davidbrown@example.com</td>
                    <td>
                      <button>Edit Profile</button>
                      <button>Remove</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Emily Davis</td>
                    <td>Staff</td>
                    <td>emilydavis@example.com</td>
                    <td>
                      <button>Edit Profile</button>
                      <button>Remove</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Robert Wilson</td>
                    <td>Professor</td>
                    <td>robertwilson@example.com</td>
                    <td>
                      <button>Edit Profile</button>
                      <button>Remove</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Olivia Taylor</td>
                    <td>Assistant</td>
                    <td>oliviataylor@example.com</td>
                    <td>
                      <button>Edit Profile</button>
                      <button>Remove</button>
                    </td>
                  </tr>
                  <tr>
                    <td>William Johnson</td>
                    <td>Staff</td>
                    <td>williamjohnson@example.com</td>
                    <td>
                      <button>Edit Profile</button>
                      <button>Remove</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Out of Service</td>
                    <td>Professor</td>
                    <td>-</td>
                    <td>
                      <button>Edit Profile</button>
                      <button>Remove</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            
              <div id="floating-form" class="hidden">
                <h2>Edit Profile</h2>
                <form id="edit-profile-form">
                  <label for="name">Name</label>
                  <input type="text" id="name" name="name" required>
                  <label for="position">Position</label>
                  <input type="text" id="position" name="position" required>
                  <label for="contact">Contact</label>
                  <input type="text" id="contact" name="contact" required>
                  <div>
                    <button type="submit">Save</button>
                    <button type="button" class="cancel-btn">Cancel</button>
                  </div>
                </form>
              </section>
        </main>
       
       
      </body>
      <script type="module" src="../src/main.js"></script>

</html>
